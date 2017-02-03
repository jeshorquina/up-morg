<?php

namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class BatchMemberModel implements ModelInterface
{
    public $BatchMemberID;
    public $BatchID;
    public $MemberID;
    public $MemberTypeID;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}