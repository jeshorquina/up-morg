<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\BatchModel;

use \Jesh\Repository\BatchRepository;

class Batch
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BatchRepository;
    }

    public function GetBatches()
    {
        $batches = array();
        foreach($this->repository->GetBatches() as $batch)
        {
            $batches[] = new BatchModel($batch);
        }
        return $batches;
    }

    public function GetActiveBatchID()
    {
        $active_batch = $this->repository->GetActiveBatchID();

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

    public function GetBatchID($acad_year)
    {
        $batch = $this->repository->GetBatchID($acad_year);

        if(sizeof($batch) === 1)
        {
            return $batch[0]["BatchID"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    "Batch with acad year = %s is not found in database!",
                    $acad_year
                )
            );
        }
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
            throw new \Exception(
                sprintf(
                    "Batch with batch id = %s is not found in database!",
                    $batch_id
                )
            );
        }
    }

    public function IsActive($batch_id)
    {
        return $this->GetActiveBatchID() == $batch_id;
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
        $is_added = $this->repository->AddBatch($batch);

        if(!$is_added)
        {
            throw new \Exception("Cound not add batch to the database");
        }

        return $is_added;
    }

    public function Activate($batch_id)
    {
        $is_activated = $this->repository->UpdateActiveBatch($batch_id);

        if(!$is_activated)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Cound not activate batch with batch id = %s in the
                        database"
                    ), $batch_id
                )
            );
        }

        return $is_activated;
    }

    public function Delete($batch_id)
    {
        $is_deleted = $this->repository->DeleteBatchByID($batch_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Cound not delete batch with batch id = %s in the
                        database"
                    ), $batch_id
                )
            );
        }

        return $is_deleted;
    }

    public function RemoveActiveBatch()
    {
        $is_removed = $this->repository->RemoveActiveBatch();

        if(!$is_removed)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Cound not remove active batch from the database."
                    ), $batch_id
                )
            );
        }

        return $is_removed;
    }
}
