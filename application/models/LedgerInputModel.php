<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class LedgerInputModel implements ModelInterfaces
{
    public $LedgerInputID;
    public $BatchMemberID;
    public $Amount;
    public $IsDebit;
    public $IsVerified;
    public $Description;
    public $Timestamp;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}