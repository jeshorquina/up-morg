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
     *               $param[0] = LedgerInputID;
     *               $param[1] = BatchMemberID;
     *               $param[2] = InputType;
     *               $param[3] = Amount;
     *               $param[4] = IsVerified;
     */ 
    public function __construct(...$params){
        $this->LedgerInputID = $params[0];
        $this->BatchMemberID = $params[1];
        $this->InputType     = $params[2];
        $this->Amount        = $params[3];
        $this->IsVerified    = $params[4];
        }
}