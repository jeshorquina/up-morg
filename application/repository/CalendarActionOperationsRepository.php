<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\EventModel;

class CalendarActionOperationsRepository extends Repository
{
    public function AddEvent(Eventmodel $event)
    {
        return Self::Insert("Event", $event);
    }
}