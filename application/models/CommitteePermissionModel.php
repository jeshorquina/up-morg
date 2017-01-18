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
     *               $param[0] = CommitteePermissionID;
     *               $param[1] = CommitteeID;
     *               $param[2] = MemberTypeID;
     */ 
     public function __construct(...$params){
         $this->CommitteePermissionID = $params[0];
         $this->CommitteeID           = $params[1];
         $this->MemberTypeID          = $params[2];
     }
}