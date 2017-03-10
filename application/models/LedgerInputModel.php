<?php

namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class LedgerInputModel implements ModelInterfaces
{
    public $LedgerInputID;
    public $BatchMemberID;
    public $InputType;
    public $Amount;
    public $IsVerified;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}