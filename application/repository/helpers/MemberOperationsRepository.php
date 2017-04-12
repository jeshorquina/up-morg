<?php
namespace Jesh\Repository\Helpers;

use \Jesh\Core\Wrappers\Repository;

class MemberOperationsRepository extends Repository
{
    public function GetMembers()
    {
        return self::Get(
            "Member", "MemberID, FirstName, MiddleName, LastName"
        );
    }

    public function GetMemberName($member_id)
    {
        return self::Get(
            "Member", "FirstName, MiddleName, LastName", array(
                "MemberID" => $member_id
            )
        );
    }

    public function GetMemberType($member_type_id)
    {
        return self::Get(
            "MemberType", "MemberType", array("MemberTypeID" => $member_type_id)
        );
    }

    public function GetCommitteeByCommitteeHead($batch_member_id)
    {
        return self::Get(
            "Committee", "CommitteeName", array(
                "CommitteeHeadID" => $batch_member_id
            )
        );
    }

    public function GetCommitteeByCommitteeMember($batch_member_id)
    {
        return self::Get(
            "Committee", "CommitteeName", array(
                "CommitteeID" => self::Get(
                    "CommitteeMember", "CommitteeID", array(
                        "BatchMemberID" => $batch_member_id
                    )
                )[0]["CommitteeID"]
            )
        );
    }
}
