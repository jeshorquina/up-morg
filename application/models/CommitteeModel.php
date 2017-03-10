<?php
namespace Jesh\Models;

use Jesh\Core\Models\ModelInterface;

class CommitteeModel implements ModelInterface
{
    public $CommitteeID;
    public $CommitteeHeadID;
    public $CommitteeName;

    public function __construct($array)
    {    
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }
}