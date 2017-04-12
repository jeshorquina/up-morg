<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Models\BatchMemberModel;

use \Jesh\Repository\Helpers\BatchMemberOperationsRepository;

class BatchMemberOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BatchMemberOperationsRepository;
    }

    public function GetBatchMembersByBatchID($batch_id, $order = "DESC")
    {
        return $this->repository->GetBatchMembersByBatchID(
            $batch_id, array("BatchMemberID" => $order)
        );
    }

    public function GetMemberIDArrayByBatchID($batch_id)
    {
        $ids = array();
        foreach($this->repository->GetMemberIDArrayByBatchID($batch_id) as $row) 
        {
            $ids[] = $row["MemberID"];
        }
        return $ids; 
    }

    public function GetBatchMemberIDArrayByBatchID($batch_id)
    {
        $batch_member_ids = $this->repository->GetBatchMemberIDArrayByBatchID(
            $batch_id
        );

        $ids = array();
        foreach($batch_member_ids as $row) 
        {
            $ids[] = $row["BatchMemberID"];
        }
        return $ids;
    }

    public function HasMember($batch_id, $member_id)
    {
        return $this->repository->HasMember($batch_id, $member_id);
    }

    public function HasBatchMember($batch_member_id)
    {
        return $this->repository->HasBatchMember($batch_member_id);
    }

    public function AddBatchMember(BatchMemberModel $batch_member)
    {
        return $this->repository->AddMember($batch_member);
    }

    public function RemoveBatchMember($batch_member_id)
    {
        return $this->repository->RemoveBatchMember($batch_member_id);
    }

    public function HasMemberType($batch_id, $member_type_id)
    {
        return $this->repository->HasMemberType($batch_id, $member_type_id);
    }

    public function RemoveMemberType($batch_member_id)
    {
        return $this->repository->RemoveMemberType($batch_member_id);
    }

    public function AddMemberType($batch_member_id, $member_type_id)
    {
        return $this->repository->AddMemberType(
            $batch_member_id, $member_type_id
        );
    }
}
