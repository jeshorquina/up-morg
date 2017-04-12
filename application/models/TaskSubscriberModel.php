<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskSubscriberModel implements ModelInterface
{
    public $TaskSubscriberID;
    public $TaskID;
    public $BatchMemberID;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}