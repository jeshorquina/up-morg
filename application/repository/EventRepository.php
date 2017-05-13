<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

class EventRepository extends Repository
{
    public function GetEvents($batch_member_id)
    {
        return self::Get("Event", "*", array("EventOwner" => $batch_member_id));
    }
}