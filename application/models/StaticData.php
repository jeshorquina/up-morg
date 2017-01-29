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
     *               $param[0] = Name;
     *               $param[1] = Value;
     */ 
    public function __construct(...$params){
        $this->Name         = $params[0];
        $this->Value        = $params[1];
    }
}