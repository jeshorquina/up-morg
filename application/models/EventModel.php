<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class EventModel implements ModelInterface
{
    public $EventID;
    public $EventOwner;
    public $EventName;
    public $EventDescription;
    public $EventStartDate;
    public $EventEndDate;
    public $EventStartTime;
    public $EventEndTime;
    public $IsPublic;
    public $Timestamp;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}