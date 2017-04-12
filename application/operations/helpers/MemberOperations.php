<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Repository\Helpers\MemberOperationsRepository;

class MemberOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new MemberOperationsRepository;
    }

    public function GetMembers()
    {
        return $this->repository->GetMembers();
    }

    public function GetMemberName($member_id)
    {
        $member = $this->repository->GetMemberName($member_id);
        if(sizeof($member) === 1) 
        {
            return str_replace(
                "  ", " ", sprintf("%s %s %s", 
                    $member[0]["FirstName"], 
                    $member[0]["MiddleName"], 
                    $member[0]["LastName"]
                )
            );
        }
        else 
        {
            return false;
        }
    }

    public function GetMemberCommittee($batch_member_id, $member_type_id)
    {
        if($member_type_id != null) 
        {
            $member_type = $this->repository->GetMemberType($member_type_id);
            if(sizeof($member_type) === 1) 
            {
                switch(trim(strtolower($member_type[0]["MemberType"]))) {
                    case "committee head":
                        return $this->GetCommittee($batch_member_id, true);
                    case "committee member":
                        return $this->GetCommittee($batch_member_id);
                    default:
                        return "Frontman";
                }
            }
            else 
            {
                return false;
            }
        }
        else {
            return "Unassigned";
        }
    }

    private function GetCommittee($batch_member_id, $is_committee_head = false)
    {
        $committee;
        if($is_committee_head) 
        {
            $committee = $this->repository->GetCommitteeByCommitteeHead(
                $batch_member_id
            );
        }
        else {
            $committee = $this->repository->GetCommitteeByCommitteeMember(
                $batch_member_id
            );
        } 

        if(sizeof($committee) === 1) 
        {
            return $committee[0]["CommitteeName"];
        }
        else 
        {
            return false;
        }
    }

    public function GetMemberPosition($member_type_id)
    {
        $member_type = $this->repository->GetMemberType($member_type_id);
        if(sizeof($member_type) === 1) 
        {
            return $member_type[0]["MemberType"];
        }
        else 
        {
            return false;
        }
    }
}
