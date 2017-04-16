<?php
namespace Jesh\Operations\LoggedOut;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;

use \Jesh\Operations\Helpers\PermissionsHelper;

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

        if($batch_member !== null)
        {
            $batch_array["id"] = $batch_id;
            $batch_array["member_id"] = $batch_member->BatchMemberID;

            if($this->committee->HasBatchMember($batch_array["member_id"]))
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
            }

            $subordinates_array = (
                $this->permission->GetSubordinateBatchMemberIDs(
                    $batch_array["member_id"], 
                    $batch_id, 
                    $batch_member->MemberTypeID
                )
            );
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
                "subordinates" => $subordinates_array
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
