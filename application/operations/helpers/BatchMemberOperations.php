<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Repository\Helpers\BatchMemberOperationsRepository;

class BatchMemberOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BatchMemberOperationsRepository;
    }

    public function GetBatchMembers($batch_id, $order = "DESC")
    {
        return $this->repository->GetBatchMembers(
            $batch_id, array(
                "BatchMemberID" => $order
            )
        );
    }

    public function GetMemberIDList($batch_id)
    {
        $ids = array();
        foreach($this->repository->GetMemberIDList($batch_id) as $row) {
            $ids[] = $row["MemberID"];
        }
        return $ids; 
    }
}
