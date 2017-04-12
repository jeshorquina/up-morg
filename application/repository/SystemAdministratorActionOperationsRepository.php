<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\StaticData;

use \Jesh\Models\BatchModel;
use \Jesh\Models\BatchMemberModel;

class SystemAdministratorActionOperationsRepository extends Repository
{

    public function GetPassword()
    {
        $record = self::Get(
            "StaticData", "Value", array("Name" => "SystemAdminPassword")
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

    public function ChangePassword($password)
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
            "Batch", "*", array(), array("AcadYear" => $order)
        );
    }

    public function GetActiveBatch()
    {
        return self::Get(
            "StaticData", "Value", array("Name" => "ActiveBatch")
        )[0]["Value"];
    }

    public function GetMembers()
    {
        return self::Get(
            "Member", "MemberID, FirstName, MiddleName, LastName"
        );
    }

    public function InsertBatchToDatabase(Batchmodel $batch)
    {
        return self::Insert("Batch", $batch);
    }

    public function GetFirstFrontmanTypeID()
    {
        return self::Get(
            "MemberType", "MemberTypeID", array(
                "MemberType" => "First Frontman"
            )
        )[0]["MemberTypeID"];
    }

    public function HasFirstFrontman($frontman_type_id, $batch_id)
    {
        return self::Find(
            "BatchMember", "BatchID", array(
                "BatchID" => $batch_id,
                "MemberTypeID" => $frontman_type_id
            )
        );
    }

    public function UpdateActiveBatch($batch_id)
    {
        return self::Update(
            "StaticData", 
            array("Name" => "ActiveBatch"), 
            array("Value" => $batch_id)
        );
    }

    public function DeleteBatchByID($batch_id)
    {
        return self::Delete("Batch", "BatchID", $batch_id);
    }

    public function ExistingBatchByID($batch_id)
    {
        return self::Find(
            "Batch", "BatchID", array(
                "BatchID" => $batch_id
            )
        );
    }

    public function ExistingBatchByYear($acad_year)
    {
        return self::Find(
            "Batch", "AcadYear", array(
                "AcadYear" => $acad_year
            )
        );
    }

    public function GetBatchAcadYear($batch_id)
    {
        return self::Get(
            "Batch", "AcadYear", array(
                "BatchID" => $batch_id
            )
        )[0]["AcadYear"];
    }

    public function AddMemberToBatch(BatchMemberModel $batch_member)
    {
        return self::Insert("BatchMember", $batch_member);
    }

    public function RemoveBatchMember($batch_member_id)
    {
        return self::Delete("BatchMember", "BatchMemberID", $batch_member_id);
    }
}