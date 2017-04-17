<?php
namespace Jesh\Operations\Admin;

use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Sort;

use \Jesh\Operations\Repository\BatchOperations;
use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

use \Jesh\Models\BatchModel;
use \Jesh\Models\BatchMemberModel;
use \Jesh\Models\CommitteeMemberModel;
use \Jesh\Models\CommitteePermissionModel;
use \Jesh\Models\MemberModel;

class BatchActionOperations
{
    private $batch;
    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->batch = new BatchOperations;
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
    }

    public function GetBatches()
    {
        $activeBatch = $this->batch->GetActiveBatchID();

        $batches = array();
        foreach($this->batch->GetBatches() as $batch)
        {
            $batch->IsActive = ($batch->BatchID == $activeBatch);
            $batches[] = $batch;
        }
        return (sizeof($batches) == 0) ? false : Sort::ObjectArray(
            $batches, "AcadYear", Sort::DESCENDING
        );
    }


    public function CheckAcadYearFormat($input)
    {
        $is_valid_format = filter_var(
            preg_match("/[0-9]{4}-[0-9]{4}/", $input), 
            FILTER_VALIDATE_BOOLEAN
        );

        if($is_valid_format) 
        {
            $years = explode("-", $input);
            return (int)$years[1] - (int)$years[0] == 1;
        }
        else {
            return false;
        }
    }

    public function ExistingBatchByID($batch_id)
    {
        return $this->batch->HasBatchID($batch_id);
    }

    public function ExistingBatchByYear($acad_year)
    {
        return $this->batch->HasAcadYear($acad_year);
    }

    public function CreateBatch($acad_year)
    {
        $is_added = $this->batch->Add(
            new BatchModel(
                array("AcadYear" => $acad_year)
            )
        );

        if($is_added)
        {
            return $this->AddCommitteePermissions($acad_year);
        }
        else
        {
            return false;
        }
    }

    public function HasFrontmen($batch_id)
    {
        return $this->batch_member->HasMemberType(
            $batch_id, $this->member->GetMemberTypeID("First Frontman")
        ) && $this->batch_member->HasMemberType(
            $batch_id, $this->member->GetMemberTypeID("Second Frontman")
        ) && $this->batch_member->HasMemberType(
            $batch_id, $this->member->GetMemberTypeID("Third Frontman")
        );
    }

    public function HasCommitteeHeads($batch_id)
    {
        $batch_members = Sort::ObjectArray(
            $this->batch_member->GetBatchMembers($batch_id), 
            "BatchMemberID", Sort::ASCENDING
        );

        $committee_head_type = $this->member->GetMemberTypeID("Committee Head");
        $committee_head_count = sizeof($this->committee->GetCommittees());
        foreach($batch_members as $batch_member)
        {
            if($batch_member->MemberTypeID == $committee_head_type)
            {
                $committee_head_count--;
            }
        }

        return $committee_head_count == 0;
    }

    public function ActivateBatch($batch_id)
    {
        return $this->batch->Activate($batch_id);
    }

    public function IsActiveBatch($batch_id)
    {
        return $this->batch->IsActive($batch_id);
    }

    public function DeleteBatch($batch_id)
    {
        return $this->batch->Delete($batch_id);
    }

    public function GetBatchDetails($batch_id)
    {
        return array(
            "batch" => array(
                "name" => $this->batch->GetAcadYear($batch_id),
                "committees" => $this->GetBatchDetailsCommittees($batch_id),
                "nonMembers" => $this->GetBatchNonMembers($batch_id)
            )
        );
    }

    public function MemberInBatch($batch_id, $member_id)
    {
        return $this->batch_member->HasMember($batch_id, $member_id);
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

    public function BatchMemberInBatch($batch_member_id)
    {
        return $this->batch_member->HasBatchMember($batch_member_id);
    }

    public function RemoveMemberFromBatch($batch_member_id)
    {
        return $this->batch_member->RemoveBatchMember($batch_member_id);
    }

    public function HasCommitteeName($committee_name)
    {
        $committee_name = StringHelper::UnmakeIndex($committee_name);

        if($committee_name == "Frontman") 
        {
            return true;
        }
        else
        {
            return $this->committee->HasCommitteeName($committee_name);
        }
    }

    public function GetBatchCommitteeDetails($batch_id, $committee_name)
    {
        $batch_members = Sort::ObjectArray(
            $this->batch_member->GetBatchMembers($batch_id), 
            "BatchMemberID", Sort::ASCENDING
        );
        $committee_members = $this->GetBatchCommitteeMembers(
            $committee_name, $batch_members
        );

        return array(
            "batch" => array(
                "name" => $this->batch->GetAcadYear($batch_id),
                "members" => $this->GetBatchCommitteeDetailsCandidates(
                    $batch_members, $committee_name, $committee_members
                ),
                "committee" => array(
                    "type" => $committee_name,
                    "members" => $committee_members
                )
            )
        );
    }

    public function AreFrontmenNonColliding($first, $second, $third)
    {
        if($first != 0 && $second != 0 && $third != 0)
        {
            return (
                $first != $second && 
                $first != $third && 
                $second != $third
            );
        }
        else if($first != 0)
        {
            return (
                $first != $second && 
                $first != $third && 
                ($second != $third || ($second + $third == 0))
            );
        }
        else if($second != 0)
        {
            return (
                $first != $second && 
                ($first != $third || ($first + $third == 0)) && 
                $second != $third
            );
        }
        else if($third != 0)
        {
            return (
                ($first != $second || ($first + $second == 0)) && 
                $first != $third && 
                $second != $third
            );
        }
        else 
        {
            return (
                $first != $second && 
                $first != $third && 
                $second != $third
            ) || $first + $second + $third == 0;
        }
    }

    public function ModifyFrontmen(
        $batch_id, $first_frontman, $second_frontman, $third_frontman
    )
    {
        $new_frontmen = array(
            "first" => $first_frontman,
            "second" => $second_frontman,
            "third" => $third_frontman
        );
        $frontmen_types = array(
            "first" => $this->member->GetMemberTypeID("First Frontman"),
            "second" => $this->member->GetMemberTypeID("Second Frontman"),
            "third" => $this->member->GetMemberTypeID("Third Frontman")
        );
        $old_frontmen = array(
            "first" => null,
            "second" => null,
            "third" => null
        );

        $batch_members = Sort::ObjectArray(
            $this->batch_member->GetBatchMembers($batch_id), 
            "BatchMemberID", Sort::ASCENDING
        );
        foreach($batch_members as $batch_member) 
        {
            foreach ($frontmen_types as $key => $frontman_type) 
            {
               if($batch_member->MemberTypeID == $frontman_type) 
               {
                    $old_frontmen[$key] = $batch_member->BatchMemberID;
                }
            }
        }

        $has_change = false;
        $active_batch_removed = false;
        foreach($old_frontmen as $key => $old_frontman_id)
        {
            $new_frontman_id = $new_frontmen[$key];
            $frontman_type = $frontmen_types[$key];

            if($new_frontman_id != $old_frontman_id)
            {
                $has_change = true;

                if($old_frontman_id !== null) 
                {
                    $this->batch_member->RemoveMemberType($old_frontman_id);
                }

                if($new_frontman_id != 0)
                {
                    if($this->committee->HasBatchMember($new_frontman_id))
                    {
                        $this->committee->RemoveCommitteeMember(
                            $new_frontman_id
                        );
                    }

                    $this->batch_member->AddMemberType(
                        $new_frontman_id, $frontman_type
                    );   
                }
                else if($this->batch->IsActive($batch_id))
                {
                    $active_batch_removed = $this->batch->RemoveActiveBatch();
                }
            }
        }

        if(!$has_change)
        {
            return array(
                "data" => array(
                    "message" => StringHelper::NoBreakString(
                        "No change in frontmen was detected. 
                        Nothing has been modified."
                    )
                ),
                "status" => false
            );
        }
        
        if($active_batch_removed && !$this->HasFrontmen($batch_id))
        {
            return array(
                "data" => array(
                    "message" => StringHelper::NoBreakString(
                        "Frontmen has been successfully changed but batch was 
                        made inactive due to unassigned frontman position."
                    )  
                ),
                "status" => true
            );
        }

        if($active_batch_removed && !$this->HasCommitteeHeads($batch_id))
        {
            return array(
                "data" => array(
                    "message" => StringHelper::NoBreakString(
                        "Frontmen has been successfully changed but batch was 
                        made inactive due to unassigned committee head 
                        position."
                    )
                ),
                "status" => true
            );
        }

        return array(
            "data" => array(
                "message" => "Frontmen has been successfully changed!"
            ),
            "status" => true
        );
    }
    
    public function AddBatchCommitteeMember(
        $batch_id, $batch_member_id, $committee_name
    ) 
    {
        $committee_id = $this->committee->GetCommitteeIDByCommitteeName(
            StringHelper::UnmakeIndex($committee_name)
        );

        if($this->committee->HasBatchMember($batch_member_id))
        {
            $this->committee->RemoveCommitteeMember($batch_member_id);
        }

        $this->committee->AddMember(
            new CommitteeMemberModel(
                array(
                    "BatchMemberID" => $batch_member_id,
                    "CommitteeID" => $committee_id, 
                    "IsApproved" => 1
                )
            )
        );

        $is_committee_member_added = $this->batch_member->AddMemberType(
            $batch_member_id, $this->member->GetMemberTypeID(
                "Committee Member"
            )
        );

        if(!$is_committee_member_added) 
        {
            array(
                "message" => (
                    StringHelper::NoBreakString(
                        "Could not add batch 
                        member to committee.Please try again."
                    )
                ),
                "status" => "error"
            );
        }

        $is_batch_active = $this->batch->IsActive($batch_id);
        if($is_batch_active && !$this->HasCommitteeHeads($batch_id))
        {
            $this->batch->RemoveActiveBatch();
            return array(
                "message" => StringHelper::NoBreakString(
                    "Batch member has been successfully added to committee but 
                    batch was made inactive due to unassigned committee head 
                    position."
                ),
                "status" => "success"
            );
        }

        return array(
            "message" => StringHelper::NoBreakString(
                "Batch member successfully added to committee."
            ),
            "status" => "success"
        );
    }

    public function RemoveBatchCommitteeMember(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        if($this->committee->HasBatchMember($batch_member_id))
        {
            $this->committee->RemoveCommitteeMember($batch_member_id);
        }

        if(!$this->batch_member->RemoveMemberType($batch_member_id))
        {
            array(
                "message" => (
                    StringHelper::NoBreakString(
                        "Could not completely remove batch member to committee. 
                        Please try again."
                    )
                ),
                "status" => false
            );
        }

        $is_batch_active = false;
        if($this->batch->IsActive($batch_id))
        {
            $this->batch->RemoveActiveBatch();
            $is_batch_active = true;

            if(!$this->HasCommitteeHeads($batch_id))
            {
                return array(
                    "message" => StringHelper::NoBreakString(
                        "Batch member has been successfully removed from 
                        committee but batch was made inactive due to unassigned 
                        committee head position."
                    ),
                    "status" => true
                );
            }
        }

        return array(
            "message" => StringHelper::NoBreakString(
                "Batch member successfully removed from committee."
            ),
            "status" => true
        );
    }

    public function UpdateBatchCommitteeHead(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        $batch_members = Sort::ObjectArray(
            $this->batch_member->GetBatchMembers($batch_id), 
            "BatchMemberID", Sort::ASCENDING
        );
        $committee_id = $this->committee->GetCommitteeIDByBatchMemberID(
            $batch_member_id
        );
        $committee_head_type_id = $this->member->GetMemberTypeID(
            "Committee Head"
        );
        $committee_member_ids = $this->committee->GetApprovedBatchMemberIDs(
            $committee_id
        );

        $committee_batch_members = array();
        foreach($batch_members as $batch_member)
        {
            if(in_array($batch_member->BatchMemberID, $committee_member_ids))
            {
                $committee_batch_members[] = $batch_member;
            }
        }

        $old_committee_head_id = null;
        foreach($committee_batch_members as $committee_member)
        {
            if($committee_member->MemberTypeID == $committee_head_type_id)
            {
                $old_committee_head_id = $committee_member->BatchMemberID;
                break;
            }
        }

        $member_response = true;
        if($old_committee_head_id != null)
        {
            $member_response = $this->batch_member->RemoveMemberType(
                $old_committee_head_id
            );

            if($member_response)
            {
                $member_response = $this->batch_member->AddMemberType(
                    $old_committee_head_id, $this->member->GetMemberTypeID(
                        "Committee Member"
                    )
                );
            }
        }

        $head_response = true;
        if($member_response)
        {
            $head_response = $this->batch_member->AddMemberType(
                $batch_member_id, $committee_head_type_id
            );
        }

        if(!$head_response || !$member_response) 
        {
            array(
                "message" => (
                    StringHelper::NoBreakString(
                        "Could not completely change batch member to committee 
                        head. Please try again."
                    )
                ),
                "status" => "error"
            );
        }
        else {
            return array(
                "message" => StringHelper::NoBreakString(
                    "Batch member successfully changed to committee head!"
                ),
                "status" => "success"
            );
        }
    }

    private function GetBatchDetailsCommittees($batch_id)
    {
        $batch_members = $this->GetBatchDetailsUnsortedBatchMembers($batch_id);

        $committees = array(
            array(
                "committee" => array(
                    "id" => "0",
                    "name" => "Unassigned"
                ),
                "members" => $this->GetBatchDetailsUnassigned($batch_members)
            ),
            array(
                "committee" => array(
                    "id" => "-1",
                    "name" => "Frontman"
                ),
                "members" => $this->GetBatchDetailsFrontmen($batch_members)
            )
        );
        foreach($this->committee->GetCommittees() as $committee) {
            
            $committees[] = array(
                "committee" => array(
                    "id"   => $committee->CommitteeID,
                    "name" => $committee->CommitteeName
                ),
                "members" => $this->GetBatchDetailsCommitteeMembers(
                    $batch_members, $committee->CommitteeName
                )
            );
        }

        return $committees;
    }

    private function GetBatchDetailsUnsortedBatchMembers($batch_id)
    {
        $batch_members = Sort::ObjectArray(
            $this->batch_member->GetBatchMembers($batch_id), 
            "BatchMemberID", Sort::ASCENDING
        );

        $members = array();
        foreach($batch_members as $batch_member) 
        {
            $name = $this->MutateMember(
                $this->member->GetMember($batch_member->MemberID) 
            )["name"];

            $committee = $this->GetBatchMemberCommitteeName(
                $batch_member->BatchMemberID, 
                $batch_member->MemberTypeID
            );
            $position = $this->GetMemberPosition($batch_member->MemberTypeID);

            $temp_member = array();

            $temp_member["id"] = $batch_member->BatchMemberID;
            $temp_member["member_type_id"] = $batch_member->MemberTypeID;
            $temp_member["name"] = $name;
            $temp_member["committee"] = $committee;
            $temp_member["position"] = $position;

            $members[] = $temp_member;
        }
        return Sort::AssociativeArray($members, "member_type_id");
    }

    private function GetBatchMemberCommitteeName(
        $batch_member_id, $member_type_id
    ) {
        if($member_type_id == 0) 
        {
            return "Unassigned";
        }

        $member_type = $this->member->GetMemberType($member_type_id);

        switch(StringHelper::MakeIndex($member_type)) {
            case "committee-head":
            case "committee-member":
                return $this->committee->GetCommitteeName(
                    $this->committee->GetCommitteeIDByBatchMemberID(
                        $batch_member_id
                    )
                );
            default:
                return "Frontman";
        }
    }

    private function GetMemberPosition($member_type_id)
    {
        if($member_type_id == 0) 
        {
            return "Unassigned";
        }
        else
        {
            return $this->member->GetMemberType($member_type_id);
        }
    }

    private function GetBatchDetailsFrontmen($batch_members)
    {
        $frontmen = array();
        foreach($batch_members as $batch_member)
        {
            if($batch_member["committee"] == "Frontman") 
            {
                $frontmen[] = array(
                    "id"       => $batch_member["id"],
                    "name"     => $batch_member["name"],
                    "position" => $batch_member["position"]
                );
            }
        }
        return $frontmen;
    }

    private function GetBatchDetailsUnassigned($batch_members)
    {
        $unassigned_members = array();
        foreach($batch_members as $batch_member)
        {
            if($batch_member["committee"] == "Unassigned") 
            {
                if($this->committee->HasBatchMember($batch_member["id"]))
                {
                    $unassigned_members[] = array(
                        "id"        => $batch_member["id"],
                        "name"      => $batch_member["name"],
                        "position"  => $batch_member["position"],
                        "committee" => $this->committee->GetCommitteeName(
                            $this->committee->GetCommitteeIDByBatchMemberID(
                                $batch_member["id"]
                            )
                        )
                    );
                }
                else 
                {
                    $unassigned_members[] = array(
                        "id"        => $batch_member["id"],
                        "name"      => $batch_member["name"],
                        "position"  => $batch_member["position"],
                        "committee" => false
                    );
                }
            }
        }
        return $unassigned_members;
    }

    private function GetBatchDetailsCommitteeMembers(
        $batch_members, $committee_name
    ) {
        $committee_members = array();
        foreach($batch_members as $batch_member)
        {
            if($batch_member["committee"] == $committee_name) 
            {
                $committee_members[] = array(
                    "id"       => $batch_member["id"],
                    "name"     => $batch_member["name"],
                    "position" => $batch_member["position"]
                );
            }
        }
        return $committee_members;
    }

    private function GetBatchNonMembers($batch_id)
    {
        $member_ids = $this->batch_member->GetMemberIDs($batch_id);

        $members = array();
        foreach($this->member->GetMembers() as $member)
        {
            if(!in_array($member->MemberID, $member_ids)) 
            {
                $members[] = $this->MutateMember($member);
            }
        }
        return $members;
    }

    private function GetBatchCommitteeDetailsCandidates(
        $batch_members, $committee_name, $committee_members
    )
    {
        $filter_ids = array();
        if($committee_name != "frontman")
        {
            foreach($committee_members as $committee_member)
            {
                $filter_ids[] = $committee_member["id"];
            }
        }
        
        $new_batch_members = array();
        foreach($batch_members as $batch_member)
        {
            if(!in_array($batch_member->BatchMemberID, $filter_ids))
            {
                $new_batch_members[] = $this->MutateBatchMember(
                    $batch_member
                );
            }
        }
        return $new_batch_members;
    }

    private function GetBatchCommitteeMembers($committee_name, $batch_members)
    {
        $committee_name = StringHelper::UnmakeIndex($committee_name);

        if($committee_name == "Frontman") 
        {
            return $this->GetBatchCommitteeDetailsFrontmen($batch_members);
        }
        else 
        {
            return $this->GetBatchCommitteeDetailsCommitteeMembers(
                $batch_members, $committee_name
            );
        }
    }

    private function GetBatchCommitteeDetailsFrontmen($batch_members)
    {
        $frontman_types = array(
            "first" => $this->member->GetMemberTypeID("First Frontman"),
            "second" => $this->member->GetMemberTypeID("Second Frontman"),
            "third" => $this->member->GetMemberTypeID("Third Frontman")
        );
        $frontman_present = array(
            "first" => false,
            "second" => false,
            "third" => false
        );

        $frontmen = array();
        foreach($batch_members as $batch_member)
        {
            foreach($frontman_types as $key => $value)
            {
                if($batch_member->MemberTypeID == $value)
                {
                    $frontman_present[$key] = true;
                    $frontmen[] = $this->MutateBatchMember($batch_member);
                }
            }
        }

        foreach($frontman_present as $key => $value)
        {
            if($value == false)
            {
                $frontmen[] = array(
                    "id"       => 0,
                    "name"     => "Unassigned",
                    "position" => $this->GetMemberPosition(
                        $frontman_types[$key]
                    )
                );
            }
        }
        return $frontmen;
    }

    private function GetBatchCommitteeDetailsCommitteeMembers(
        $batch_members, $committee_name
    )
    {
        $batch_members = $this->FilterBatchMembersByCommittee(
            $batch_members, $this->committee->GetCommitteeIDByCommitteeName(
                $committee_name
            )
        );

        $committee_members = array();
        foreach($batch_members as $batch_member)
        {
            $committee_members[] = $this->MutateBatchMember($batch_member);
        }
        return $committee_members;
    }

    private function FilterBatchMembersByCommittee(
        $batch_members, $committee_id
    ) 
    {
        $filtered_batch_members = array();
        foreach($batch_members as $batch_member) 
        {
            $is_approved = $this->committee->IsBatchMemberCommitteeApproved(
                $batch_member->BatchMemberID, $committee_id
            );

            if($is_approved) // includes being in committee
            {
                $filtered_batch_members[] = $batch_member;
            }
        }
        return $filtered_batch_members;
    }

    private function MutateBatchMember($batch_member)
    {
        return array(
            "id" => $batch_member->BatchMemberID,
            "name" => $this->MutateMember(
                $this->member->GetMember($batch_member->MemberID) 
            )["name"],
            "position" => $this->GetMemberPosition($batch_member->MemberTypeID)
        );
    }

    private function MutateMember(MemberModel $member)
    {
        return array(
            "id" => $member->MemberID,
            "name" => str_replace(
                "  ", " ", sprintf("%s %s %s", 
                    $member->FirstName, 
                    $member->MiddleName, 
                    $member->LastName
                )
            )
        );
    }

    private function AddCommitteePermissions($acad_year)
    {
        // NOTE: Temporary solution until rebust addition
        // of permission via parenting (i.e. use of tree)
        // is implemented.
        $batch_id = $this->batch->GetBatchID($acad_year);
        $permissions = array(
            $this->member->GetMemberTypeID("First Frontman") => (
                array(1,2,3,4,5,6,7)
            ),
            $this->member->GetMemberTypeID("Second Frontman") => (
                array(1,2,3)
            ),
            $this->member->GetMemberTypeID("Third Frontman") => (
                array(4,5,6)
            )
        );

        foreach($permissions as $member_type_id => $committee_ids)
        {
            foreach($committee_ids as $committee_id)
            {
                $this->committee->AddCommitteePermission(
                    new CommitteePermissionModel(
                        array(
                            "BatchID" => $batch_id,
                            "MemberTypeID" => $member_type_id,
                            "CommitteeID" => $committee_id
                        )
                    )
                );
            }
        }

        return true;
    }
}
