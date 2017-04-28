<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\AvailabilityMemberModel;

class AvailabilityOperationsRepository extends Repository
{
    public function GetAvailability($batch_member_id)
    {
        return self::Get("AvailabilityMember", "*", 
            array("BatchMemberID" => $batch_member_id)
        );
    }

    public function AddAvailability(AvailabilityMemberModel $availability)
    {
        return self::Insert("AvailabilityMember", $availability);
    }

    public function UpdateAvailability(
        $batch_member_id, AvailabilityMemberModel $availability
    ) {
        return self::Update("AvailabilityMember", array(
            "BatchMemberID" => $batch_member_id
        ), $availability);
    }
}