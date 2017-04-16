<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\BatchMemberModel;

class BatchMemberOperationsRepository extends Repository
{
    public function GetBatchMembers($batch_id)
    {
        return self::Get("BatchMember", "*", array("BatchID" => $batch_id));
    }

    public function GetMemberIDs($batch_id)
    {
        return self::Get(
            "BatchMember", "MemberID", array("BatchID" => $batch_id)
        );
    }

    public function GetBatchMemberID($batch_id, $member_id)
    {
        return self::Get("BatchMember", "BatchMemberID", array(
            "BatchID" => $batch_id, "MemberID" => $member_id
        ));
    }

    public function HasBatchMember($batch_member_id)
    {
        return self::Find("BatchMember", "BatchMemberID", array(
            "BatchMemberID" => $batch_member_id
        ));
    }

    public function HasMember($batch_id, $member_id)
    {
        return self::Find("BatchMember", "BatchMemberID", array(
            "BatchID" => $batch_id, "MemberID" => $member_id
        ));
    }

    public function HasMemberType($batch_id, $member_type_id)
    {
        return self::Find("BatchMember", "BatchMemberID", array(
            "BatchID" => $batch_id, "MemberTypeID" => $member_type_id
        ));
    }

    public function AddMember(BatchMemberModel $batch_member)
    {
        return self::Insert("BatchMember", $batch_member);
    }

    public function AddMemberType($batch_member_id, $member_type_id)
    {
        return self::Update(
            "BatchMember", array("BatchMemberID" => $batch_member_id),
            new BatchMemberModel(array("MemberTypeID" => $member_type_id))
        );
    }

    public function RemoveBatchMember($batch_member_id)
    {
        return self::Delete("BatchMember", "BatchMemberID", $batch_member_id);
    }

    public function RemoveMemberType($batch_member_id)
    {
        return self::Update(
            "BatchMember", array("BatchMemberID" => $batch_member_id),
            new BatchMemberModel(array("MemberTypeID" => 0))
        );
    }
}
