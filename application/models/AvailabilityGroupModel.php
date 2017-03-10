<?php

namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityGroupModel implements ModelInterface
{
    public $FrontmanID;
    public $Groupname;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
