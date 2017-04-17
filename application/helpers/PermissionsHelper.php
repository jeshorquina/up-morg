<?php
namespace Jesh\Helpers;

use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

class PermissionsHelper
{
    public function __construct()
    {
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
    }

    public function GetSubordinateBatchMemberIDs(
        $batch_member_id, $batch_id, $member_type_id
    )
    {
        // NOTE: IN THE FUTURE, IMPLEMENT A DYNAMIC MEMBER STRUCTURE HEIRARCHY
        // I.E. TREE IN DB...
        $member_type = $this->member->GetMemberType($member_type_id);

        if($member_type == "First Frontman")
        {
            return $this->batch_member->GetBatchMemberIDs($batch_id);
        }


        if($member_type == "Second Frontman" || $member_type == "Third Frontman")
        {
            $scoped_committees = (
                $this->committee->GetCommitteePermissionCommitteeIDs(
                    $batch_id, $member_type_id
                )
            );

            $subordinate_ids = array();
            foreach($scoped_committees as $committee_id)
            {
                $subordinate_ids = array_merge(
                    $subordinate_ids, 
                    $this->committee->GetBatchMemberIDs($committee_id)
                );
            }

            $frontmen_types= array(
                $this->member->GetMemberTypeID("First Frontman"),
                $this->member->GetMemberTypeID("Second Frontman"),
                $this->member->GetMemberTypeID("Third Frontman")
            );

            $batch_members = (
                $this->batch_member->GetBatchMembers($batch_id)
            );

            $frontmen_ids = array();
            foreach($batch_members as $batch_member) 
            {
                if(in_array($batch_member->MemberTypeID, $frontmen_types))
                {
                    $frontmen_ids[] = $batch_member->BatchMemberID;
                }
            }
            return array_merge($frontmen_ids, $subordinate_ids);
        }
        else if($member_type == "Committee Head")
        {
            return $this->committee->GetBatchMemberIDs(
                $this->committee->GetCommitteeIDByBatchMemberID(
                    $batch_member_id
                )
            );
        }
        else if ($member_type == "Committee Member")
        {
            return array($batch_member_id);
        }
        else 
        {
            return array();
        }
    }
}