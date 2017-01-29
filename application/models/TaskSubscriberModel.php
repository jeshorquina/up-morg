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
     *               $param[0] = TaskID;
     *               $param[1] = BatchMemberID;
     */ 
     public function __construct(...$params){
         $this->TaskID           = $params[0];
         $this->BatchMemberID    = $params[1];
     }
}