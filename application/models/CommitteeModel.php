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
     *               $param[0] = CommitteeHeadID;
     *               $param[1] = CommitteeName;
     */ 
     public function __construct(...$params){
        $this->CommitteeHeadID = $params[0];
        $this->CommitteeName   = $params[1];
     }
}