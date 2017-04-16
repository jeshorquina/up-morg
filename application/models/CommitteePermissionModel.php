<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class CommitteePermissionModel implements ModelInterface 
{
    public $CommitteePermissionID;
    public $BatchID;
    public $MemberTypeID;
    public $CommitteeID;

   public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}