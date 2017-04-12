<?php
namespace Jesh\Repository\Helpers;

use \Jesh\Core\Wrappers\Repository;

class BatchMemberOperationsRepository extends Repository
{
    public function GetBatchMembers(
        $batch_id, $order = array("BatchMemberID" => "DESC")
    )
    {
        return self::Get(
            "BatchMember", "*", array("BatchID" => $batch_id), $order
        );
    }

    public function GetMemberIDList($batch_id)
    {
        return self::Get(
            "BatchMember", "MemberID", array("BatchID" => $batch_id)
        );
    }
}
