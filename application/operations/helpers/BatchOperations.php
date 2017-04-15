<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Models\BatchModel;

use \Jesh\Repository\BatchOperationsRepository;

class BatchOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BatchOperationsRepository;
    }

    public function GetBatches()
    {
        $activeBatch = $this->GetActiveBatch();

        $batches = array();
        foreach($this->repository->GetBatches() as $batch)
        {
            $batch["IsActive"] = ($batch["BatchID"] == $activeBatch);
            $batches[] = $batch;
        }
        return (sizeof($batches) != 0) ? $batches : false;
    }

    public function HasBatchID($batch_id)
    {
        return $this->repository->HasBatchID($batch_id);
    }

    public function HasAcadYear($acad_year)
    {
        return $this->repository->HasAcadYear($acad_year);
    }

    public function Add(BatchModel $batch)
    {
        return $this->repository->AddBatch($batch);
    }

    public function Delete($batch_id)
    {
        return $this->repository->DeleteBatchByID($batch_id);
    }

    public function Activate($batch_id)
    {
        return $this->repository->UpdateActiveBatch($batch_id);
    }

    public function IsActive($batch_id)
    {
        return $this->GetActiveBatch() == $batch_id;
    }

    public function GetAcadYear($batch_id)
    {
        $batch = $this->repository->GetAcadYear($batch_id);

        if(sizeof($batch) === 1)
        {
            return $batch[0]["AcadYear"];
        }
        else 
        {
            return false;
        }
    }

    public function RemoveActiveBatch()
    {
        return $this->repository->RemoveActiveBatch();
    }

    private function GetActiveBatch()
    {
        $active_batch = $this->repository->GetActiveBatch();

        if(sizeof($active_batch) === 1)
        {
            return $active_batch[0]["Value"];
        }
        else 
        {
            throw new \Exception(
                "No active batch entry found on database static data!"
            );
        }
    }
}
