<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class CommitteeModel implements ModelInterface {

    public $CommitteeID;
    public $CommitteeHeadID;
    public $CommitteeName;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = CommitteeID;
     *               $param[1] = CommitteeHeadID;
     *               $param[2] = CommitteeName;
     */ 
     public function __construct(...$params){
        $this->CommitteeID     = $params[0];
        $this->CommitteeHeadID = $params[1];
        $this->CommitteeName   = $params[2];
     }
}