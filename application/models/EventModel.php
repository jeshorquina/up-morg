<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class EventModel implements ModelInterface {

    public $EventID;
    public $EventOwner;
    public $EventName;
    public $EventDescription;
    public $EventDate;
    public $EventTime;
    public $Timestamp;
    public $IsPublic;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = EventOwner;
     *               $param[1] = EventName;
     *               $param[2] = EventDescription;
     *               $param[3] = EventDate;
     *               $param[4] = EventTime;
     *               $param[5] = Timestamp;
     *               $param[6] = IsPublic;
     */ 
     public function __construct(...$params){
         $this->EventOwner       = $params[0];
         $this->EventName        = $params[1];
         $this->EventDescription = $params[2];
         $this->EventDate        = $params[3];
         $this->EventTime        = $params[4];
         $this->Timestamp        = $params[5];
         $this->IsPublic         = $params[6];
     }
}