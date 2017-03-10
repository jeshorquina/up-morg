<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class MemberModel implements ModelInterface
{
    public $MemberID;
    public $FirstName;
    public $MiddleName;
    public $LastName;
    public $EmailAddress;
    public $PhoneNumber;
    public $Password;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}
