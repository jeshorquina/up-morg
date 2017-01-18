<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskSubscriberModel implements ModelInterface {

    public $TaskSubscriberID;
    public $TaskID;
    public $BatchMemberID;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = TasksubscriberID;
     *               $param[1] = TaskID;
     *               $param[2] = BatchMemberID;
     */ 
     public function __construct(...$params){
         $this->TaskSubscriberID = $params[0];
         $this->TaskID           = $params[1];
         $this->BatchMemberID    = $params[2];
     }
}