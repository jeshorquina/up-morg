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

    public function GetEvent($event_id)
    {
        $event = $this->repository->GetEvent($event_id);

        if(!$event)
        {
            throw new \Exception(
                sprintf(
                    "Cannot find event with id = %s in the database",
                    $event_id
                )
            );
        }

        return new EventModel($event[0]);
    }

    public function HasEvent($event_id)
    {
        return $this->repository->HasEvent($event_id);
    }

    public function DeleteEvent($event_id)
    {
        return $this->repository->DeleteEvent($event_id);
    }
}
