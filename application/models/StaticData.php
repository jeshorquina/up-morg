<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class StaticDataModel implements ModelInterface {

    public $StaticDataID;
    public $Name;
    public $Value;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = StaticDataID;
     *               $param[1] = Name;
     *               $param[2] = Value;
     */ 
    public function __construct(...$params){
        $this->StaticDataID = $params[0];
        $this->Name         = $params[1];
        $this->Value        = $params[2];
    }
}