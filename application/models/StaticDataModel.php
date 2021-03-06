<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class StaticDataModel implements ModelInterface
{
    public $StaticDataID;
    public $Name;
    public $Value;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}