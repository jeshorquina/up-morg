<?php
namespace Jesh\Operations\User;

use \Jesh\Models\AvailabilityMemberModel;
use \Jesh\Models\AvailabilityGroupModel;
use \Jesh\Models\AvailabilityGroupMemberModel;

use \Jesh\Operations\Repository\Availability;
use \Jesh\Operations\Repository\BatchMember;
use \Jesh\Operations\Repository\Committee;
use \Jesh\Operations\Repository\Member;

class AvailabilityActionOperations
{
    private $availability;
    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->availability = new Availability;
        $this->batch_member = new BatchMember;
        $this->committee = new Committee;
        $this->member = new Member;
    }

    public function GetAvailability($batch_member_id)
    {
        return $this->EncodeSchedule(
            $this->availability->GetAvailabilityByBatchMemberID(
                $batch_member_id
            )
        );
    }

    public function UpdateAvailability($schedule, $batch_member_id)
    {
        $monday    = array();
        $tuesday   = array();
        $wednesday = array();
        $thursday  = array();
        $friday    = array();
        $saturday  = array();
        $sunday    = array();

        foreach($schedule as $index => $row) 
        {
            $monday[$index]    = $row["Monday"];
            $tuesday[$index]   = $row["Tuesday"];
            $wednesday[$index] = $row["Wednesday"];
            $thursday[$index]  = $row["Thursday"];
            $friday[$index]    = $row["Friday"];
            $saturday[$index]  = $row["Saturday"];
            $sunday[$index]    = $row["Sunday"];
        }

        return $this->availability->UpdateAvailability(
            $batch_member_id,
            new AvailabilityMemberModel(
                array(
                    "MondayVector"    => implode($monday),
                    "TuesdayVector"   => implode($tuesday),
                    "WednesdayVector" => implode($wednesday),
                    "ThursdayVector"  => implode($thursday),
                    "FridayVector"    => implode($friday),
                    "SaturdayVector"  => implode($saturday),
                    "SundayVector"    => implode($sunday)
                )
            )
        );
    }

    public function GetMemberAvailability(
        $batch_id, $frontman_id, $is_first_frontman
    )
    {
        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, 
                $this->batch_member->GetMemberTypeID($frontman_id)
                
            )
        );

        $scoped_batch_member_ids = array();

        if($is_first_frontman) 
        {
            $frontmen = array(
                $this->member->GetMemberTypeID(
                    Member::SECOND_FRONTMAN
                ),
                $this->member->GetMemberTypeID(
                    Member::THIRD_FRONTMAN
                )
            );

            foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
            {
                if(in_array($member->MemberTypeID, $frontmen))
                {
                    $scoped_batch_member_ids[] = $member->BatchMemberID;
                }
            }
        }
        
        foreach($scoped_committees as $committee_id) 
        {
            $scoped_batch_member_ids = array_merge(
                $scoped_batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        $scoped_batch_member_ids = array_intersect(
            $scoped_batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $final_details = array();
        foreach($scoped_batch_member_ids as $batch_member_id) {
            $final_details[] = array(
                "owner" => $this->GetMemberName(
                    $this->batch_member->GetMemberID($batch_member_id)
                ),
                "schedule" => $this->GetAvailability($batch_member_id)
            );
        }
        return $final_details;
    }

    public function GetAvailabilityGroups($frontman_id)
    {
        $groups = array();
        foreach($this->availability->GetGroups($frontman_id) as $group)
        {
            $groups[] = array(
                "id" => $group->AvailabilityGroupID,
                "name" => $group->GroupName
            );
        }
        return array("groups" => $groups);
    }

    public function AddAvailabilityGroup($frontman_id, $group_name)
    {
        return $this->availability->AddGroup(
            new AvailabilityGroupModel(
                array(
                    "FrontmanID" => $frontman_id,
                    "GroupName" => $group_name
                )
            )
        );
    }

    public function CheckGroupOwnership($group_id, $frontman_id)
    {
        $db_frontman_id = $this->availability->GetGroup($group_id)->FrontmanID;
        return $db_frontman_id == $frontman_id;
    }

    public function DeleteAvailabilityGroup($group_id)
    {
        return $this->availability->DeleteGroup($group_id);
    }

    public function GetAvailabilityGroupViewDetails($group_id)
    {
        $members = array();
        foreach($this->availability->GetMemberIDs($group_id) as $member_id)
        {
            $availability = (
                $this->availability->GetAvailabilityByMemberID(
                    $member_id
                )
            );

            $group_member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($availability->BatchMemberID)
            );

            $members[] = array(
                "name" => $group_member_name,
                "schedule" => $this->EncodeSchedule($availability)
            );
        }

        return array(
            "group" => array(
                "name" => $this->availability->GetGroup($group_id)->GroupName,
                "members" => $members
            )
        );
    }

    public function GetAvailabilityGroupEditDetails(
        $group_id, $batch_id, $frontman_id, $is_first_frontman
    )
    {
        $members = array();
        $included_member_ids = array();
        foreach($this->availability->GetGroupMembers($group_id) as $member)
        {
            $group_member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID(
                    $this->availability->GetAvailabilityByMemberID(
                        $member->AvailabilityMemberID
                    )->BatchMemberID
                )
            );
            $members[] = array(
                "id" => $member->AvailabilityMemberID,
                "name" => $group_member_name
            );

            $included_member_ids[] = $member->AvailabilityMemberID;
        }

        $scoped_committees = (
            $this->committee->GetCommitteePermissionCommitteeIDs(
                $batch_id, 
                $this->batch_member->GetMemberTypeID($frontman_id)
                
            )
        );

        $scoped_batch_member_ids = array($frontman_id);

        if($is_first_frontman) 
        {
            $frontmen = array(
                $this->member->GetMemberTypeID(
                    Member::SECOND_FRONTMAN
                ),
                $this->member->GetMemberTypeID(
                    Member::THIRD_FRONTMAN
                )
            );

            foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
            {
                if(in_array($member->MemberTypeID, $frontmen))
                {
                    $scoped_batch_member_ids[] = $member->BatchMemberID;
                }
            }
        }

        foreach($scoped_committees as $committee_id) 
        {
            $scoped_batch_member_ids = array_merge(
                $scoped_batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        $scoped_batch_member_ids = array_intersect(
            $scoped_batch_member_ids,
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        $non_members = array();
        foreach($scoped_batch_member_ids as $batch_member_id) 
        {
            $member = $this->availability->GetAvailabilityByBatchMemberID(
                $batch_member_id
            );

            if(!in_array($member->AvailabilityMemberID, $included_member_ids))
            {
                $member_name = $this->GetMemberName(
                    $this->batch_member->GetMemberID($batch_member_id)
                );
                $non_members[] = array(
                    "id" => $member->AvailabilityMemberID,
                    "name" => $member_name
                );
            }
        }

        return array(
            "group" => array(
                "name" => $this->availability->GetGroup($group_id)->GroupName,
                "members" => $members
            ),
            "members" => $non_members
        );
    }

    public function HasAvailabilityMember($member_id)
    {
        return $this->availability->HasAvailability($member_id);
    }

    public function HasAvailabilityGroupMember($group_id, $member_id)
    {
        return $this->availability->HasGroupMember($group_id, $member_id);
    }

    public function AddGroupMember($group_id, $member_id)
    {
        return $this->availability->AddGroupMember(
            new AvailabilityGroupMemberModel(
                array(
                    "AvailabilityMemberID" => $member_id,
                    "AvailabilityGroupID" => $group_id
                )
            )
        );
    }

    public function DeleteGroupMember($group_id, $member_id)
    {
        return $this->availability->DeleteGroupMember(
            $this->availability->GetGroupMemberID(
                $group_id, $member_id
            )
        );
    }

    public function GetAvailabilityCommitteeDetails($batch_id, $committee_id)
    {
        $members = array();

        $committee_batch_member_ids = array_intersect(
            $this->committee->GetApprovedBatchMemberIDs($committee_id),
            $this->batch_member->GetBatchMemberIDs($batch_id)
        );

        foreach($committee_batch_member_ids as $batch_member_id)
        {
            $member = $this->availability->GetAvailabilityByBatchMemberID(
                $batch_member_id
            );

            $availability = (
                $this->availability->GetAvailabilityByMemberID(
                    $member->AvailabilityMemberID
                )
            );

            $group_member_name = $this->GetMemberName(
                $this->batch_member->GetMemberID($availability->BatchMemberID)
            );

            $members[] = array(
                "name" => $group_member_name,
                "schedule" => $this->EncodeSchedule($availability)
            );
        }

        return array(
            "committee" => array(
                "members" => $members
            )
        );
    }

    private function EncodeSchedule($availability)
    {
        $monday = str_split($availability->MondayVector);
        $tuesday = str_split($availability->TuesdayVector);
        $wednesday = str_split($availability->WednesdayVector);
        $thursday = str_split($availability->ThursdayVector);
        $friday = str_split($availability->FridayVector);
        $saturday = str_split($availability->SaturdayVector);
        $sunday = str_split($availability->SundayVector);

        $processed_availability = array();
        for($i = 0; $i < sizeof($monday); $i++)
        {
            $processed_availability[$i] = array(
                "Sunday" => $sunday[$i],
                "Monday" => $monday[$i],
                "Tuesday" => $tuesday[$i],
                "Wednesday" => $wednesday[$i],
                "Thursday" => $thursday[$i],
                "Friday" => $friday[$i],
                "Saturday" => $saturday[$i],
            );
        }

        return $processed_availability;
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
