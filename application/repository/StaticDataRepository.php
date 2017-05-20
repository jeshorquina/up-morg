<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\StaticDataModel;

class StaticDataRepository extends Repository
{
    public function GetAdminPassword()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "SystemAdminPassword")
        );
    }

    public function ChangePassword($password)
    {
        return self::Update(
            "StaticData", array("Name" => "SystemAdminPassword"), 
            new StaticDataModel(array("Value" => $password))
        );
    }

    public function GetAcadYearStartMonth()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "AcadYearStartMonth")
        );
    }

    public function GetAcadYearEndMonth()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "AcadYearEndMonth")
        );
    }
}