<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskCommentModel implements ModelInterface
{
    public $TaskCommentID;
    public $TaskID;
    public $TaskSubscriberID;
    public $Comment;
    public $Timestamp;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}