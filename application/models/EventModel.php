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
     *               $param[0] = EventID;
     *               $param[1] = EventOwner;
     *               $param[2] = EventName;
     *               $param[3] = EventDescription;
     *               $param[4] = EventDate;
     *               $param[5] = EventTime;
     *               $param[6] = Timestamp;
     *               $param[7] = IsPublic;
     */ 
     public function __construct(...$params){
         $this->EventID          = $params[0];
         $this->EventOwner       = $params[1];
         $this->EventName        = $params[2];
         $this->EventDescription = $params[3];
         $this->EventDate        = $params[4];
         $this->EventTime        = $params[5];
         $this->Timestamp        = $params[6];
         $this->IsPublic         = $params[7];
     }
}