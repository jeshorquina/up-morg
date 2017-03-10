<?php
namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class TaskStatusModel implements ModelInterface
{
    public $TaskStatusID;
    public $Name;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}