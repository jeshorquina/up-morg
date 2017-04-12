<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class LedgerInputModel implements ModelInterface
{
    public $LedgerInputID;
    public $BatchMemberID;
    public $Amount;
    public $IsDebit;
    public $IsVerified;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}