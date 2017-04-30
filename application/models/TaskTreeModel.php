<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskTreeModel implements ModelInterface
{
    public $TaskTreeID;
    public $ChildTaskID;
    public $ParentTaskID;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}