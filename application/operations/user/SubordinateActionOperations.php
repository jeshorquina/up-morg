<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\StringHelper;

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

    public function GetFrontmanBatchDetails($batch_id, $frontman_id)
    {
        $batch_details = $this->admin_batch->GetBatchDetails($batch_id);

        $scoped_committees = array_merge(
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID($frontman_id)
            ),
            array(0)
        );

        $committees = array();
        $unassigned_index = 0;
        foreach($batch_details["batch"]["committees"] as $key => $committee)
        {
            if($committee["committee"]["id"] == 0)
            {
                $unassigned_index = $key;
            }

            if(in_array($committee["committee"]["id"], $scoped_committees))
            {
                $committees[] = $committee;
            }
        }
        $batch_details["batch"]["committees"] = $committees;

        return $this->FilterUnassignedMembersWithCommitteeScope(
            $batch_details, $batch_id, $frontman_id, $unassigned_index
        );
    }

    public function GetCommitteeHeadBatchDetails($batch_id, $committee_head_id)
    {
        $batch_details = $this->admin_batch->GetBatchDetails($batch_id);

        $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
            $committee_head_id
        );

        $committees = array();
        foreach($batch_details["batch"]["committees"] as $key => $committee)
        {
            if($committee["committee"]["id"] == $committee_id)
            {
                $committees[] = $committee;
            }
        }
        $batch_details["batch"]["committees"] = $committees;

        return $batch_details;
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

    public function GetFrontmanCommitteeDetails(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        $unassigned_members = $this->FilterUnassignedMembers(
            $this->admin_batch->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            )
        );
        
        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );

        $unassigned = [];
        foreach($unassigned_members["batch"]["members"] as $member)
        {
            if(in_array($member["committee"], $scoped_committees))
            {
                $unassigned[] = $member;
            }
        }

        $unassigned_members["batch"]["members"] = $unassigned;

        return $unassigned_members;
    }

    public function GetCommitteeHeadCommitteeDetails(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        $unassigned_members = $this->FilterUnassignedMembers(
            $this->admin_batch->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            )
        );

        $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
            $batch_member_id
        );

        $unassigned = [];
        foreach($unassigned_members["batch"]["members"] as $member)
        {
            if($member["committee"] == $committee_id)
            {
                $unassigned[] = $member;
            }
        }

        $unassigned_members["batch"]["members"] = $unassigned;

        return $unassigned_members;
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

    public function IsCommitteeHead($batch_member_id, $committee_name)
    {
        return $this->committee->IsBatchMemberInCommittee(
            $batch_member_id, 
            $this->committee->GetCommitteeIDByCommitteeName(
                $committee_name
            )
        ) && $this->batch_member->GetMemberTypeID($batch_member_id) == (
            $this->member->GetMemberTypeID("Committee Head")
        );
    }

    public function IsMemberTypeCommitteeMember($batch_member_id)
    {
        return $this->member->GetMemberType(
            $this->batch_member->GetMemberTypeID($batch_member_id)
        ) == "Committee Member";
    }

    public function HasCommitteeAccess(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        return in_array(
            $this->committee->GetCommitteeIDByCommitteeName(
                StringHelper::UnmakeIndex($committee_name)
            ),
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );
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
        $this->batch_member->AddMemberType(
            $batch_member_id, 
            $this->member->GetMemberTypeID("Committee Member")
        );

        $committee_id = $this->committee->GetCommitteeIDByCommitteeName(
            $committee_name
        );

        if($this->committee->HasBatchMember($batch_member_id))
        {
            return $this->committee->UpdateMember(
                $batch_member_id, 
                new CommitteeMemberModel(
                    array(
                        "CommitteeID" => $committee_id,
                        "IsApproved" => 1
                    )
                )
            );
        }
        else
        {
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

    private function FilterUnassignedMembersWithCommitteeScope(
        $committee_details, $batch_id, $batch_member_id, $unassigned_index
    )
    {
        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, $this->batch_member->GetMemberTypeID(
                    $batch_member_id
                )
            )
        );

        $unassigned_committee = (
            $committee_details["batch"]["committees"][$unassigned_index]
        );
        $unassigned_members = array();
        foreach($unassigned_committee["members"] as $member
        )
        {
            if($member["committee"] != false)
            {
                $member_committee_id = (
                    $this->committee->GetCommitteeIDByCommitteeName(
                        $member["committee"]
                    )
                );

                if(in_array($member_committee_id, $scoped_committees))
                {
                    $unassigned_members[] = $member;
                }
            }
        }

        $committee_details["batch"]["committees"][$unassigned_index]["members"] = (
            $unassigned_members
        );
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
