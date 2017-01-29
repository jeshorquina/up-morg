<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskModel implements ModelInterface {

    public $TaskID;
    public $ParentTaskID;
    public $TaskStatusID;
    public $EventID;
    public $Reporter;
    public $Assignee;
    public $TaskTitle;
    public $TaskDescription;
    public $TaskDeadline;
    public $Timestamp;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = ParentTaskID;
     *               $param[1] = TaskStatusID;
     *               $param[2] = EventID;
     *               $param[3] = Reporter;
     *               $param[4] = Assignee;
     *               $param[5] = TaskTitle;
     *               $param[6] = TaskDescription;
     *               $param[7] = TaskDeadline;
     *               $param[8] = Timestamp;
     */ 
     public function __construct(...$params){
        $this->ParentTaskID    = $params[0];
        $this->TaskStatusID    = $params[1];
        $this->EventID         = $params[2];
        $this->Reporter        = $params[3];
        $this->Assignee        = $params[4];
        $this->TaskTitle       = $params[5];
        $this->TaskDescription = $params[6];
        $this->TaskDeadline    = $params[7];
        $this->Timestamp       = $params[8]; 
     }
}