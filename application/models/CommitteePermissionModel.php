<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class CommitteePermissionModel implements ModelInterface {

    public $CommitteePermissionID;
    public $CommitteeID;
    public $MemberTypeID;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = CommitteeID;
     *               $param[1] = MemberTypeID;
     */ 
     public function __construct(...$params){
         $this->CommitteeID           = $params[0];
         $this->MemberTypeID          = $params[1];
     }
}