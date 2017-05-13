<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

class EventRepository extends Repository
{
    public function GetEvents($batch_member_id)
    {
        return self::Get("Event", "*", array("EventOwner" => $batch_member_id));
    }

    public function GetEvent($event_id)
    {
        return self::Get("Event", "*", array("EventID" => $event_id));
    }

    public function HasEvent($event_id)
    {
        return self::Find("Event", "EventID", array("EventID" => $event_id));
    }

    public function DeleteEvent($event_id)
    {
        return self::Delete("Event", "EventID", $event_id);
    }
}