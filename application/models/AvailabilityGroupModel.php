<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityGroupModel implements ModelInterface
{
    public $AvailabilityGroupID;
    public $FrontmanID;
    public $GroupName;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
