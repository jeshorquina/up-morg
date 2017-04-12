<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class MemberTypeModel implements ModelInterface
{
    public $MemberTypeID;
    public $MemberType;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}