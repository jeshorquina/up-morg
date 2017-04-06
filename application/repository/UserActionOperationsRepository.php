<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\MemberModel;

class UserActionOperationsRepository extends Repository
{
    public function GetBatches($order)
    {
        return self::Get(
            "Batch", "*", 
            array(), 
            array("AcadYear" => $order)
        );
    }

    public function GetMembers()
    {
        return self::Get(
            "Member", 
            "FirstName, LastName"
        );
    }
}