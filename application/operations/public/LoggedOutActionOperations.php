<?php
namespace Jesh\Operations\LoggedOut;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Sort;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;

use \Jesh\Operations\Repository\Batch;
use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Event;
use \Jesh\Operations\Repository\Member;

class LoggedOutActionOperations
{
    private $batch;
    private $batch_member;
    private $committee;
    private $event;
    private $member;

    public function __construct()
    {
        $this->batch = new Batch;
        $this->batch_member = new BatchMember;
        $this->committee = new Committee;
        $this->event = new Event;
        $this->member = new Member;
    }

    public function ValidateLoginData($username, $password)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckEmail("username", $username);
        $validation->CheckString("password", $password);

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
        $batch_array = array();
        $committee_array = array();
        $flags_array = array();

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

        if($batch_member !== null)
        {
            $batch_array["id"] = $batch_id;
            $batch_array["member_id"] = $batch_member->BatchMemberID;
            $batch_array["member_type_id"] = $batch_member->MemberTypeID;

            $is_committee_member = $this->committee->HasBatchMember(
                $batch_member->BatchMemberID
            );

            if($is_committee_member)
            {
                $is_approved_committee_member = (
                    $this->committee->IsBatchMemberApproved(
                        $batch_member->BatchMemberID
                    )
                );

                if($is_approved_committee_member) // assigned
                {
                    $committee_array["id"] = (
                        $this->committee->GetCommitteeIDByBatchMemberID(
                            $batch_member->BatchMemberID
                        )
                    );
                    $committee_array["member_id"] = (
                        $this->committee->GetCommitteeMemberID(
                            $batch_member->BatchMemberID
                        )
                    );

                    $flags_array["is_batch_member"] = true;
                    $flags_array["is_frontman"] = false;
                    $flags_array["is_first_frontman"] = false;
                    $flags_array["is_committee_member"] = true;
                    $flags_array["is_committee_head"] = (
                        $this->member->GetMemberType(
                            $batch_member->MemberTypeID
                        ) === Member::COMMITTEE_HEAD
                    );
                    $flags_array["is_finance"] = (
                        $this->committee->GetCommitteeName(
                            $committee_array["id"]
                        ) === Committee::FINANCE
                    );
                }
                else // unapproved
                {
                    $flags_array["is_batch_member"] = true;
                    $flags_array["is_frontman"] = false;
                    $flags_array["is_first_frontman"] = false;
                    $flags_array["is_committee_head"] = false;
                    $flags_array["is_committee_member"] = false;
                    $flags_array["is_finance"] = false;
                }
            }
            else if(!(bool)$batch_member->MemberTypeID) // unassigned
            {
                $flags_array["is_batch_member"] = true;
                $flags_array["is_frontman"] = false;
                $flags_array["is_first_frontman"] = false;
                $flags_array["is_committee_head"] = false;
                $flags_array["is_committee_member"] = false;
                $flags_array["is_finance"] = false;
            }
            else // Frontmen
            {
                $flags_array["is_batch_member"] = true;
                $flags_array["is_frontman"] = true;
                $flags_array["is_first_frontman"] = (
                    $this->member->GetMemberType(
                        $batch_member->MemberTypeID
                    ) === Member::FIRST_FRONTMAN
                );
                $flags_array["is_committee_head"] = false;
                $flags_array["is_committee_member"] = false;
                $flags_array["is_finance"] = (
                    $this->member->GetMemberType(
                        $batch_member->MemberTypeID
                    ) === Member::FIRST_FRONTMAN
                );
            }
        }
        else
        {
            $flags_array["is_batch_member"] = false;
            $flags_array["is_frontman"] = false;
            $flags_array["is_first_frontman"] = false;
            $flags_array["is_committee_head"] = false;
            $flags_array["is_committee_member"] = false;
            $flags_array["is_finance"] = false;
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
                "flags"        => $flags_array
            )
        ));
    }

    public function ValidateRegistrationData($registration_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($registration_data as $name => $value)
        {
            if($name === "email_address") 
            {
                $validation->CheckEmail($name, $value);
            }
            if(strtolower(gettype($value)) === "string")
            {
                $validation->CheckString($name, $value);
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

    public function GetPublicEvents()
    {
        $events = array();
        foreach($this->event->GetAllEvents() as $event)
        {
            if((bool)$event->IsPublic)
            {
                $events[] = array(
                    "id" => $event->EventID,
                    "owner" => $this->GetMemberName(
                        $this->member->GetMember(
                            $this->batch_member->GetMemberID($event->EventOwner)
                        )
                    ),
                    "name" => $event->EventName,
                    "description" => $event->EventDescription,
                    "date" => $this->MutateEventDate($event),
                    "timestamp" => $this->MutateTimestamp($event->Timestamp)
                );
            }
        }
        return Sort::AssociativeArray($events, "timestamp", SORT::DESCENDING);
    }

    private function GetMemberName(MemberModel $member)
    {
        return str_replace('  ', ' ', sprintf(
                "%s %s %s", 
                $member->FirstName, 
                $member->MiddleName, 
                $member->LastName
            )
        );
    }

    private function MutateEventDate($event_object)
    {
        if($event_object->EventEndDate != null)
        {
            return sprintf(
                "%s to %s", 
                date("F j, Y", strtotime($event_object->EventStartDate)),
                date("F j, Y", strtotime($event_object->EventEndDate))
            );
        }
        else if($event_object->EventTime != null)
        {
            return date(
                "F j, Y - g:i a",
                strtotime(
                    sprintf(
                        "%s %s", 
                        $event_object->EventStartDate, 
                        $event_object->EventTime
                    )
                )
            );
        }
        else
        {
            return date("F j, Y", strtotime($event_object->EventStartDate));
        }
    }
    
    private function MutateTimestamp($timestamp)
    {
        return date("F j, Y - g:i a", strtotime($timestamp));
    }
}
