<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class CommitteeMemberModel implements ModelInterface {

    public $CommitteeMemberID;
    public $BatchMemberID;
    public $CommitteeID;
    public $IsApproved;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = BatchMemberID;
     *               $param[1] = CommitteeID;
     *               $param[2] = IsApproved;
     */ 
     public function __construct(...$params){
        $this->BatchMemberID     = $params[0];
        $this->CommitteeID       = $params[1];
        $this->IsApproved        = $params[2];
     }
}