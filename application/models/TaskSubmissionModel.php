<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class TaskSubmissionModel implements ModelInterface
{
    public $TaskSubmissionID;
    public $TaskID;
    public $Description;
    public $FilePath;
    public $Timestamp;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}