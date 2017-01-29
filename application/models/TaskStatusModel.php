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
     *               $param[0] = Name;
     */ 
     public function __construct(...$params){
         $this->Name = $params[0];
     }
}