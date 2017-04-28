<?php
namespace Jesh\Operations\User;

use \Jesh\Models\AvailabilityMemberModel;

use \Jesh\Operations\Repository\AvailabilityOperations;
use \Jesh\Operations\Repository\BatchMemberOperations;
use \Jesh\Operations\Repository\CommitteeOperations;
use \Jesh\Operations\Repository\MemberOperations;

class AvailabilityActionOperations
{
    private $availability;
    private $batch_member;
    private $committee;
    private $member;

    public function __construct()
    {
        $this->availability = new AvailabilityOperations;
        $this->batch_member = new BatchMemberOperations;
        $this->committee = new CommitteeOperations;
        $this->member = new MemberOperations;
    }

    public function GetAvailability($batch_member_id)
    {
        $availability = $this->availability->GetAvailability($batch_member_id);

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
        foreach($scoped_committees as $committee_id) 
        {
            $scoped_batch_member_ids = array_merge(
                $scoped_batch_member_ids, 
                $this->committee->GetApprovedBatchMemberIDs($committee_id)
            );
        }

        if($is_first_frontman) 
        {
            foreach($this->batch_member->GetBatchMembers($batch_id) as $member)
            {
                $member_type = $this->member->GetMemberType(
                    $member->MemberTypeID
                );
                if(
                    $member_type == "Second Frontman" || 
                    $member_type == "Third Frontman"
                )
                {
                    $scoped_batch_member_ids[] = $member->BatchMemberID;
                }
            }
            
        }

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
