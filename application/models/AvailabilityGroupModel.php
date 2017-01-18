<?php

namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityGroupModel implements ModelInterface {
    
    public $AvailabilityGroupID;
    public $FrontmanID;
    public $Groupname;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = AvailabilityGroupID;
     *               $param[1] = FrontmanID;
     *               $param[2] = Groupname;   
     */
     public function __construct(...$params){
         $this->AvailabilityGroupID = $params[0];
         $this->FrontmanID          = $params[1];
         $this->Groupname           = $params[2];
     }
}
