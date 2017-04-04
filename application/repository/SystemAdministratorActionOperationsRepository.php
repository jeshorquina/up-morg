<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\StaticData;

use \Jesh\Models\BatchModel;

class SystemAdministratorActionOperationsRepository extends Repository
{
    public function GetPassword()
    {
        $record = self::Get(
            "StaticData", 
            "Value", 
            array("Name" => "SystemAdminPassword")
        );
        
        if(sizeof($record) === 1)
        {
            return $record[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for system admin password found");
        }
    }

    public function UpdatePassword($password)
    {
        return self::Update(
            "StaticData", 
            array("Name" => "SystemAdminPassword"), 
            array("Value" => $password)
        );
    }

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
            "MemberID, FirstName, MiddleName, LastName"
        );
    }

    public function InsertBatchToDatabase(Batchmodel $batch)
    {
        return self::Insert("Batch", $batch);
    }

    public function DeleteBatchByID($value)
    {
        return self::Delete("Batch", "BatchID", $value);
    }

    public function ExistingBatchByID($value)
    {
        return self::Find("Batch", "BatchID", $value);
    }

    public function ExistingBatchByYear($value)
    {
        return self::Find("Batch", "AcadYear", $value);
    }
}