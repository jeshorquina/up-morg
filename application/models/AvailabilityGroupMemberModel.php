<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class AvailabilityGroupMemberModel implements ModelInterface {

    public $AvailabilityGroupMemberID;
    public $AvailabilityMemberID;
    public $AvailabilityGroupID;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = AvailabilityGroupMemberID;
     *               $param[1] = AvailabilityMemberID;
     *               $param[2] = AvailabilityGroupID;   
     */
     public function __construct(...$params){
         $this->AvailabilityGroupMemberID = $params[0];
         $this->AvailabilityMemberID      = $params[1];
         $this->AvailabilityGroupID       = $params[2];
     }
}
