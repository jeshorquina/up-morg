<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class CommitteePermissionModel implements ModelInterface 
{
    public $CommitteePermissionID;
    public $CommitteeID;
    public $MemberTypeID;

   public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}