<?php
namespace Jesh\Models;

use \Jesh\Core\Interfaces\ModelInterface;

class CommitteeMemberModel implements ModelInterface 
{
    public $CommitteeMemberID;
    public $BatchMemberID;
    public $CommitteeID;
    public $IsApproved;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}