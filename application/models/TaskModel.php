<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskModel implements ModelInterface
{
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

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}