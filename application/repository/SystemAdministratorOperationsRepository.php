<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\StaticData;

class SystemAdministratorOperationsRepository extends Repository
{
    public function GetPassword()
    {
        $record = self::Get(
            "StaticData", 
            "Value", 
            array("Name" => "SystemAdminPassword")
        );
        return $record[0]["Value"];
    }

    public function UpdatePassword($password)
    {
        return self::Update(
            "StaticData", 
            array("Name" => "SystemAdminPassword"), 
            array("Value" => $password)
        );
    }
}