<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityGroupMemberModel implements ModelInterface {

    public $AvailabilityGroupMemberID;
    public $AvailabilityMemberID;
    public $AvailabilityGroupID;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
