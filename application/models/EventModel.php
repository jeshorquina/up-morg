<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class EventModel implements ModelInterface
{
    public $EventID;
    public $EventOwner;
    public $EventName;
    public $EventDescription;
    public $EventDate;
    public $EventTime;
    public $IsPublic;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}