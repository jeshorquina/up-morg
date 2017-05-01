<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\BatchModel;
use \Jesh\Models\StaticDataModel;

class BatchRepository extends Repository
{
    public function GetBatches()
    {
        return self::Get("Batch", "*");
    }

    public function GetActiveBatchID()
    {
        return self::Get("StaticData", "Value", array("Name" => "CurrentBatch"));
    }

    public function GetBatchID($acad_year)
    {
        return self::Get("Batch", "BatchID", array("AcadYear" => $acad_year));
    }

    public function GetAcadYear($batch_id)
    {
        return self::Get("Batch", "AcadYear", array("BatchID" => $batch_id));
    }

    public function HasBatchID($batch_id)
    {
        return self::Find("Batch", "BatchID", array("BatchID" => $batch_id));
    }

    public function HasAcadYear($acad_year)
    {
        return self::Find("Batch", "AcadYear", array("AcadYear" => $acad_year));
    }

    public function AddBatch(BatchModel $batch)
    {
        return self::Insert("Batch", $batch);
    }

    public function UpdateActiveBatch($batch_id)
    {
        return self::Update(
            "StaticData", array("Name" => "CurrentBatch"), 
            new StaticDataModel(array("Value" => $batch_id))
        );
    }

    public function RemoveActiveBatch()
    {
        return $this->UpdateActiveBatch(0);
    }

    public function DeleteBatchByID($batch_id)
    {
        return self::Delete("Batch", "BatchID", $batch_id);
    }
}
