<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskEventModel implements ModelInterface
{
    public $TaskEventID;
    public $TaskID;
    public $EventID;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}