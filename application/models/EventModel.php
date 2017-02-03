<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class EventModel implements ModelInterface
{
    public $EventID;
    public $EventOwner;
    public $EventName;
    public $EventDescription;
    public $EventDate;
    public $EventTime;
    public $Timestamp;
    public $IsPublic;

   public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}