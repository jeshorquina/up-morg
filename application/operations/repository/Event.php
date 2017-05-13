<?php
namespace Jesh\Operations\Repository;

use \Jesh\Models\EventModel;

use \Jesh\Repository\EventRepository;

class Event
{
    private $repository;

    public function __construct()
    {
        $this->repository = new EventRepository;
    }

    public function GetEvents($batch_member_id)
    {
        $events = array();
        foreach($this->repository->GetEvents($batch_member_id) as $event)
        {
            $events[] = new EventModel($event);
        }
        return $events;
    }
}
