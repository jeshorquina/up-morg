<?php

namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class BatchMemberModel implements ModelInterface {

    public $BatchMemberID;
    public $BatchID;
    public $MemberID;
    public $MemberTypeID;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *               $param[0] = BatchMemberID;  
     *               $param[1] = BatchID;
     *               $param[2] = MemberID;
     *               $param[3] = MemberTypeID;
     */
     public function __construct(...$params){
         $this->BatchMemberID = $params[0];
         $this->BatchID       = $params[1];
         $this->MemberID      = $params[2];
         $this->MemberTypeID  = $params[3];
     }
}