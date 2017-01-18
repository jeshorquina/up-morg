<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskStatusModel implements ModelInterface {

    public $TaskStatusID;
    public $Name;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = TaskStatusID;
     *               $param[1] = Name;
     */ 
     public function __construct(...$params){
         $this->TaskStatusID = $params[0];
         $this->Name = $params[1];
     }
}