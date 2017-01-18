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
     *               $param[0] = CommitteeMemberID;
     *               $param[1] = BatchMemberID;
     *               $param[2] = CommitteeID;
     *               $param[3] = IsApproved;
     */ 
     public function __construct(...$params){
        $this->CommitteeMemberID = $params[0];
        $this->BatchMemberID     = $params[1];
        $this->CommitteeID       = $params[2];
        $this->IsApproved        = $params[3];
     }
}