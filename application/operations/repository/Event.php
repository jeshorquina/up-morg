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

    public function AddEvent(EventModel $event)
    {
        $is_added = $this->repository->AddEvent($event);

         if(!$is_added)
        {
            throw new \Exception("Cannot add event in the database");
        }

        return $is_added;
    }

    public function EditEvent($event_id, EventModel $event)
    {
        $is_edited = $this->repository->EditEvent($event_id, $event);

         if(!$is_edited)
        {
            throw new \Exception(
                sprintf(
                    "Cannot edit event with id = %s in the database",
                    $event_id
                )
            );
        }

        return $is_edited;
    }

    public function DeleteEvent($event_id)
    {
        $is_deleted = $this->repository->DeleteEvent($event_id);

         if(!$is_deleted)
        {
            throw new \Exception(
                sprintf(
                    "Cannot delete event with id = %s from the database",
                    $event_id
                )
            );
        }

        return $is_deleted;
    }
}
