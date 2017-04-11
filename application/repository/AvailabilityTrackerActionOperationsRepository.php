<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\AvailabilityMemberModel;

class AvailabilityTrackerActionOperationsRepository extends Repository
{
    public function UpdateSchedule(AvailabilityMemberModel $availability)
    {
        return self::Insert("AvailabilityMember", $availability);
    }

    public function ExistingSchedule($user_id)
    {
        return self::Find("AvailabilityMember", "BatchMemberID", $user_id);
    }

    public function UpdateExistingSchedule(AvailabilityMemberModel $availability, $user_id)
    {
        return self::Update("AvailabilityMember", array("BatchMemberID" => $user_id), array("SundayVector" => $availability->SundayVector,
                                                                                            "MondayVector" => $availability->MondayVector,
                                                                                            "TuesdayVector" => $availability->TuesdayVector,
                                                                                            "WednesdayVector" => $availability->WednesdayVector,
                                                                                            "ThursdayVector" => $availability->ThursdayVector,
                                                                                            "FridayVector" => $availability->FridayVector,
                                                                                            "SaturdayVector" => $availability->SaturdayVector)
                                                       );
    }
}