<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

class AvailabilityOperationsRepository extends Repository
{
    public function GetAvailability($batch_member_id)
    {
        return self::Get("AvailabilityMember", "*", 
            array("BatchMemberID" => $batch_member_id)
        );
    }
}