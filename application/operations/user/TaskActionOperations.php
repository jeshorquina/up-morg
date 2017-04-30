<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Sort;

use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

class TaskActionOperations
{
    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
    }

    public function GetFrontmanAddTaskPageDetails($batch_id, $frontman_id)
    {
        $frontmen = array(
            $this->member->GetMemberTypeID(
                "First Frontman"
            ),
            $this->member->GetMemberTypeID(
                "Second Frontman"
            ),
            $this->member->GetMemberTypeID(
                "Third Frontman"
            )
        );

        foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
        {
            if(in_array($member->MemberTypeID, $frontmen))
            {
                $batch_member_ids[] = $member->BatchMemberID;
            }
        }

        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID($frontman_id)
            )
        );

        foreach($scoped_committees as $committee_id) 
        {
            $batch_member_ids = array_merge(
                $batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        $members = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );
        }

        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => Sort::AssociativeArray(
                $members, "name", Sort::ASCENDING
            ),
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    public function GetCommitteeHeadAddTaskPageDetails($committee_id)
    {
        $batch_member_ids = (
            $this->committee->GetApprovedBatchMemberIDs($committee_id)
        );

        $members = array();
        foreach($batch_member_ids as $batch_member_id)
        {
            $member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($batch_member_id)
            );
            $members[] = array(
                "id" => $batch_member_id,
                "name" => $member_name
            );
        }

        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => Sort::AssociativeArray(
                $members, "name", Sort::ASCENDING
            ),
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    public function GetCommitteeMemberAddTaskPageDetails($committee_member_id)
    {
        $members = array();
        $members[] = array(
            "id" => $committee_member_id,
            "name" => $this->GetMemberName(
                $this->batch_member->GetMemberID($committee_member_id)
            )
        );


        $events = array();

        $tasks = array();

        return array(
            "events" => $events,
            "members" => $members,
            "tasks" => Sort::AssociativeArray($tasks, "id", Sort::DESCENDING)
        );
    }

    private function GetMemberName($member_id)
    {
        $member = $this->member->GetMember($member_id);

        return str_replace(
            "  ", " ",
            sprintf(
                "%s %s %s", 
                $member->FirstName, 
                $member->MiddleName, 
                $member->LastName
            )
        ); 
    }
}
