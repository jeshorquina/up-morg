<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class MemberModel implements ModelInterface {

    public $MemberID;
    public $FirstName;
    public $MiddleName;
    public $LastName;
    public $EmailAddress;
    public $PhoneNumber;
    public $Password;

    /**
     * Constructs the database model
     *
     * @param $param Array An array containing the 
     *               following:
     *
     *               $param[0] = FirstName;
     *               $param[1] = MiddleName;
     *               $param[2] = LastName;
     *               $param[3] = EmailAddress;
     *               $param[4] = PhoneNumber;
     *               $param[5] = Password;     
     */
     public function __construct(...$params){
         $this->FirstName = $params[0];
         $this->MiddleName = $params[1];
         $this->LastName = $params[2];
         $this->EmailAddress = $params[3];
         $this->PhoneNumber = $params[4];
         $this->Password = $params[5];
     }

}