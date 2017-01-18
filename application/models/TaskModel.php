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
     *               $param[0] = TaskID;
     *               $param[1] = ParentTaskID;
     *               $param[2] = TaskStatusID;
     *               $param[3] = EventID;
     *               $param[4] = Reporter;
     *               $param[5] = Assignee;
     *               $param[6] = TaskTitle;
     *               $param[7] = TaskDescription;
     *               $param[8] = TaskDeadline;
     *               $param[9] = Timestamp;
     */ 
     public function __construct(...$params){
        $this->TaskID          = $params[0];
        $this->ParentTaskID    = $params[1];
        $this->TaskStatusID    = $params[2];
        $this->EventID         = $params[3];
        $this->Reporter        = $params[4];
        $this->Assignee        = $params[5];
        $this->TaskTitle       = $params[6];
        $this->TaskDescription = $params[7];
        $this->TaskDeadline    = $params[8];
        $this->Timestamp       = $params[9]; 
     }
}