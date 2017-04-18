<?php
namespace Jesh\Operations\User;

use \Jesh\Models\BatchMemberModel;
use \Jesh\Models\CommitteeMemberModel;

use \Jesh\Operations\Admin\BatchActionOperations;
use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

class SubordinateActionOperations
{
    private $batch_member;
    private $committee;
    private $member;

    private $admin_batch;

    public function __construct()
    {
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;

        $this->admin_batch = new BatchActionOperations;
    }

    public function GetFirstFrontmanBatchDetails($batch_id)
    {
        return $this->admin_batch->GetBatchDetails($batch_id);
    }

    public function GetFrontmanDetails($batch_id)
    {
        return $this->FilterFrontmanMembers(
            $this->admin_batch->GetBatchCommitteeDetails(
                $batch_id, "frontman"
            )
        );
    }

    public function GetFirstFrontmanCommitteeDetails($batch_id, $committee_name)
    {
        return $this->FilterUnassignedMembers(
            $this->admin_batch->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            )
        );
    }

    public function MemberInBatch($batch_id, $member_id)
    {
        return $this->batch_member->HasMember($batch_id, $member_id);
    }

    public function BatchMemberInBatch($batch_member_id)
    {
        return $this->batch_member->HasBatchMember($batch_member_id);
    }

    public function IsCommitteeMember($batch_member_id, $committee_name)
    {
        return $this->committee->IsBatchMemberInCommittee(
            $batch_member_id, 
            $this->committee->GetCommitteeIDByCommitteeName(
                $committee_name
            )
        );
    }

    public function IsMemberTypeCommitteeMember($batch_member_id)
    {
        return $this->member->GetMemberType(
            $this->batch_member->GetMemberTypeID($batch_member_id)
        ) == "Committee Member";
    }

    public function AddMemberToBatch($batch_id, $member_id)
    {
        return $this->batch_member->AddBatchMember(
            new BatchMemberModel(
                array(
                    "BatchID" => $batch_id,
                    "MemberID" => $member_id
                )
            )
        );
    }

    public function AddMemberToCommittee($batch_member_id, $committee_name)
    {
        if($this->committee->HasBatchMember($batch_member_id))
        {
            return $this->committee->UpdateMember(
                $batch_member_id, 
                new CommitteeMemberModel(array("IsApproved" => 1))
            );
        }
        else
        {
            $this->batch_member->AddMemberType(
                $batch_member_id, 
                $this->member->GetMemberTypeID("Committee Member")
            );

            $committee_id = $this->committee->GetCommitteeIDByCommitteeName(
                $committee_name
            );

            return $this->committee->AddMember(
                new CommitteeMemberModel(
                    array(
                        "BatchMemberID" => $batch_member_id,
                        "CommitteeID" => $committee_id,
                        "IsApproved" => 1
                    )
                )
            );
        }
    }

    public function AssignCommitteeHead($batch_member_id, $committee_name)
    {
        $batch_member_ids = $this->committee->GetApprovedBatchMemberIDs(
            $this->committee->GetCommitteeIDByCommitteeName(
                $committee_name
            )
        );

        foreach($batch_member_ids as $id)
        {
            $this->batch_member->AddMemberType(
                $id, $this->member->GetMemberTypeID("Committee Member")
            );
        }

        return $this->batch_member->AddMemberType(
            $batch_member_id, 
            $this->member->GetMemberTypeID("Committee Head")
        );
    }

    public function ModifyFrontman($batch_id, $second, $third)
    {
        $batch_members = $this->batch_member->GetBatchMembers($batch_id);
        
        $second_type = $this->member->GetMemberTypeID("Second Frontman");
        $third_type = $this->member->GetMemberTypeID("Third Frontman");

        foreach($batch_members as $batch_member)
        {
            if($batch_member->BatchMemberID == $second)
            {
                $this->committee->RemoveCommitteeMember(
                    $batch_member->BatchMemberID
                );
                $this->batch_member->AddMemberType(
                    $batch_member->BatchMemberID, 
                    $this->member->GetMemberTypeID("Second Frontman")
                );
            }
            else if($batch_member->BatchMemberID == $third)
            {
                $this->committee->RemoveCommitteeMember(
                    $batch_member->BatchMemberID
                );
                $this->batch_member->AddMemberType(
                    $batch_member->BatchMemberID, 
                    $this->member->GetMemberTypeID("Third Frontman")
                );
            }
            else if(
                $batch_member->MemberTypeID == $third_type ||
                $batch_member->MemberTypeID == $second_type
            )
            {
                $this->batch_member->AddMemberType(
                    $batch_member->BatchMemberID, 
                    $this->member->GetMemberTypeID("Unassigned")
                );
            }
        }

        return true;
    }

    public function RemoveMemberFromBatch($batch_member_id)
    {
        return $this->batch_member->RemoveBatchMember($batch_member_id);
    }

    public function RemoveMemberFromCommittee($batch_member_id)
    {
        $this->batch_member->RemoveMemberType($batch_member_id);
        return $this->committee->RemoveCommitteeMember($batch_member_id);
    }

    private function FilterUnassignedMembers($committee_details)
    {
        $unassigned_members = array();
        foreach($committee_details["batch"]["members"] as $member)
        {
            if($member["position"] === "Unassigned")
            {
                $unassigned_members[] = $member;
            }
        }
        $committee_details["batch"]["members"] = $unassigned_members;
        return $committee_details;
    }

    private function FilterFrontmanMembers($frontman_details)
    {
        $members = array();
        foreach($frontman_details["batch"]["members"] as $member)
        {
            if(
                $member["position"] === "Unassigned" || 
                $member["position"] === "Second Frontman" ||
                $member["position"] === "Third Frontman"
            )
            {
                $members[] = $member;
            }
        }
        $frontman_details["batch"]["members"] = $members;

        $frontmen = array();
        foreach($frontman_details["batch"]["committee"]["members"] as $frontman)
        {
            if($frontman["position"] !== "First Frontman")
            {
                $frontmen[] = $frontman;
            }
        }
        $frontman_details["batch"]["committee"]["members"] = $frontmen;

        return $frontman_details;
    }
}
