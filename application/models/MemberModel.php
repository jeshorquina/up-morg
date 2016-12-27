<?php 
namespace Jesh\Models;

use \Jesh\Models\ModelInterface;

class MemberModel implements ModelInterface {

    public $MemberID;
    public $FirstName;
    public $MiddleName;
    public $LastName;
    public $EmailAddress;
    public $PhoneNumber;
    public $Password;

}
