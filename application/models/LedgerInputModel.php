<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class LedgerInputModel implements ModelInterface {

    public $LedgerInputID;
    public $BatchMemberID;
    public $InputType;
    public $Amount;
    public $IsVerified;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = BatchMemberID;
     *               $param[1] = InputType;
     *               $param[2] = Amount;
     *               $param[3] = IsVerified;
     */ 
    public function __construct(...$params){
        $this->BatchMemberID = $params[0];
        $this->InputType     = $params[1];
        $this->Amount        = $params[2];
        $this->IsVerified    = $params[3];
        }
}