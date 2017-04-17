<?php
namespace Jesh\Operations\LoggedOut;

use \Jesh\Helpers\PermissionsHelper;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;

use \Jesh\Operations\Repository\BatchOperations;
use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

class LoggedOutActionOperations
{
    private $batch;
    private $batch_member;
    private $committee;
    private $member;
    private $permission;

    public function __construct()
    {
        $this->batch = new BatchOperations;
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
        $this->permission = new PermissionsHelper;
    }

    public function ValidateLoginData($username, $password)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString("username", $username);
        $validation->CheckString("password", $password);
        $validation->CheckEmail("username", $username);
                
        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function ExistingUsername($username)
    {
        return $this->member->HasEmailAddress($username);
    }

    public function MatchingPassword($username, $password) 
    {
        return Security::CheckPassword($password, 
            $this->member->GetPasswordByEmailAddress($username)
        );
    }

    public function SetLoggedInState($username)
    { 
        $member_details = $this->member->GetMember(
            $this->member->GetMemberIDByEmailAddress($username)
        );

        $batch_id = $this->batch->GetActiveBatchID();

        $batch_member = null;
        if($this->batch_member->HasMember($batch_id, $member_details->MemberID))
        {
            $batch_member = $this->batch_member->GetBatchMember(
                $batch_id, $member_details->MemberID
            );
        }

        $batch_array = array();
        $committee_array = array();
        $subordinates_array = array();
        $flags_array = array(
            "is_batch_member" => false,
            "is_committee_member" => false,
            "is_frontman" => false,
            "is_head" => false,
            "is_finance" => false
        );

        if($batch_member !== null)
        {
            $flags_array["is_batch_member"] = true;

            $batch_array["id"] = $batch_id;
            $batch_array["member_id"] = $batch_member->BatchMemberID;

            $subordinates_array = (
                $this->permission->GetSubordinateBatchMemberIDs(
                    $batch_array["member_id"], 
                    $batch_id, 
                    $batch_member->MemberTypeID
                )
            );

            if(
                $this->committee->HasBatchMember($batch_array["member_id"]) && 
                sizeof($subordinates_array) !== 0
            )
            {
                $committee_array["id"] = (
                    $this->committee->GetCommitteeIDByBatchMemberID(
                        $batch_array["member_id"]
                    )
                );
                $committee_array["member_id"] = (
                    $this->committee->GetCommitteeMemberID(
                        $batch_array["member_id"]
                    )
                );

                $flags_array["is_committee_member"] = true;
                $flags_array["is_frontman"] = false;
                $flags_array["is_head"] = (
                    $this->member->GetMemberType(
                        $batch_member->MemberTypeID
                    ) === "Committee Head"
                );
                $flags_array["is_finance"] = (
                    $this->committee->GetCommitteeName(
                        $committee_array["id"]
                    ) === "Finance"
                );
            }
            else if(sizeof($subordinates_array) !== 0)
            {
                $flags_array["is_frontman"] = true;
                $flags_array["is_finance"] = true;
            }
        }

        Session::Clear();
        return Session::Set("user_data", json_encode(
            array(
                "member" => array(
                    "id"            => $member_details->MemberID,
                    "first_name"    => $member_details->FirstName,
                    "middle_name"   => $member_details->MiddleName,
                    "last_name"     => $member_details->LastName,
                    "email_address" => $member_details->EmailAddress,
                    "phone_number"  => $member_details->PhoneNumber
                ),
                "batch"        => $batch_array,
                "committee"    => $committee_array, 
                "subordinates" => $subordinates_array,
                "flags"        => $flags_array
            )
        ));
    }

    public function ValidateRegistrationData($registration_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($registration_data as $name => $value)
        {
            if(strtolower(gettype($value)) === "string") 
            {
                $validation->CheckString($name, $value);
            }
            if($name === "email_address") 
            {
                $validation->CheckEmail($name, $value);
            }
        }
        
        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function CreateMember(
        $first_name, $middle_name, $last_name, $email, $phone, $password
    )
    {
        $member_details = new MemberModel(
            array(
                "FirstName"    => $first_name,
                "MiddleName"   => $middle_name,
                "LastName"     => $last_name,
                "EmailAddress" => $email,
                "PhoneNumber"  => $phone,
                "Password"     => Security::GenerateHash($password),
            )
        );

        if(!$this->member->Add($member_details))
        {
            return array(
                "status" => false,
                "data" => "Member has not been successfully created."
            );
        }
        else
        {
            return array(
                "status" => true,
                "data" => "Member has been successfully created."
            );
        }
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }
}
