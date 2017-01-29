<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class MemberTypeModel implements ModelInterface {

    public $MemberTypeID;
    public $MemberType;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = MemberType;
     */ 
    public function __construct(...$params){
        $this->MemberType   = $params[0];
    }
}