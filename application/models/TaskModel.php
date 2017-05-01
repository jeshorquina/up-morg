<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskModel implements ModelInterface
{
    public $TaskID;
    public $TaskStatusID;
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