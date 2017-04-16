<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\BatchMemberModel;

use \Jesh\Repository\BatchMemberOperationsRepository;

class BatchMemberOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new BatchMemberOperationsRepository;
    }

    public function GetBatchMembers($batch_id)
    {
        $batch_members = array();
        foreach($this->repository->GetBatchMembers($batch_id) as $batch_member){
            $batch_members[] = new BatchMemberModel($batch_member);
        }
        return $batch_members;
    }

    public function GetMemberIDs($batch_id)
    {
        $ids = array();
        foreach($this->repository->GetMemberIDs($batch_id) as $row) 
        {
            $ids[] = $row["MemberID"];
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

    public function HasMemberType($batch_id, $member_type_id)
    {
        return $this->repository->HasMemberType($batch_id, $member_type_id);
    }

    public function AddBatchMember(BatchMemberModel $batch_member)
    {
        $is_added = $this->repository->AddMember($batch_member);

        if(!$is_added)
        {
            throw new \Exception("Cound not add batch member to the database");
        }

        return $is_added;
    }

    public function AddMemberType($batch_member_id, $member_type_id)
    {
        $is_added = $this->repository->AddMemberType(
            $batch_member_id, $member_type_id
        );

        if(!$is_added)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Could not update member type id of batch member with
                        batch member id = %s"
                    ), $batch_member_id
                )
            );
        }

        return $is_added;
    }

    public function RemoveBatchMember($batch_member_id)
    {
        $is_removed = $this->repository->RemoveBatchMember($batch_member_id);

        if(!$is_removed)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Could not remove batch member with id = %s"
                    ), $batch_member_id
                )
            );
        }

        return $is_removed;
    }

    public function RemoveMemberType($batch_member_id)
    {
        $is_removed = $this->repository->RemoveMemberType($batch_member_id);

        if(!$is_removed)
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Could not remove member type of batch member 
                        with batch member id = %s"
                    ), $batch_member_id
                )
            );
        }

        return $is_removed;
    }
}
