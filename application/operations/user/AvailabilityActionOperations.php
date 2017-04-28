<?php
namespace Jesh\Operations\User;

use \Jesh\Models\AvailabilityMemberModel;

use \Jesh\Operations\Repository\AvailabilityOperations;

class AvailabilityActionOperations
{
    public function __construct()
    {
        $this->availability = new AvailabilityOperations;
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
}
