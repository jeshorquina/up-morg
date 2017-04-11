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
}