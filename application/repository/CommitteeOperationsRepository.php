<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\CommitteeMemberModel;
use \Jesh\Models\CommitteePermissionModel;

class CommitteeOperationsRepository extends Repository
{
    public function GetCommittees()
    {
        return self::Get("Committee", "*");
    }

    public function GetCommitteeIDByCommitteeName($committee_name)
    {
        return self::Get("Committee", "CommitteeID", array(
            "CommitteeName" => $committee_name
        ));
    }

    public function GetCommitteeIDByBatchMemberID($batch_member_id)
    {
        return self::Get(
            "CommitteeMember", "CommitteeID", array(
                "BatchMemberID" => $batch_member_id
            )
        );
    }

    public function GetCommitteeName($committee_id)
    {
        return self::Get(
            "Committee", "CommitteeName", array("CommitteeID" => $committee_id)
        );
    }

    public function GetCommitteeMemberID($batch_member_id)
    {
        return self::Get("CommitteeMember", "CommitteeMemberID", array(
            "BatchMemberID" => $batch_member_id
        ));
    }

    public function GetCommitteeMembers($committee_id)
    {
        return self::Get(
            "CommitteeMember", "*", array("CommitteeID" => $committee_id)
        );
    }

    public function GetCommitteePermissionCommitteeID(
        $batch_id, $member_type_id
    )
    {
        return self::Get(
            "CommitteePermission", "CommitteeID", array(
                "BatchID" => $batch_id, "MemberTypeID" => $member_type_id
            )
        );
    }

    public function HasCommitteeName($committee_name)
    {
        return self::Find("Committee", "CommitteeName", array(
            "CommitteeName" => $committee_name
        ));
    }

    public function HasBatchMember($batch_member_id)
    {
        return self::Find("CommitteeMember", "BatchMemberID", array(
            "BatchMemberID" => $batch_member_id
        ));
    }
    
    public function IsBatchMemberInCommittee($batch_member_id, $committee_id)
    {
        return self::Find("CommitteeMember", "CommitteeMemberID", array(
            "BatchMemberID" => $batch_member_id,
            "CommitteeID" => $committee_id
        ));
    }

    public function IsBatchMemberApproved($batch_member_id, $committee_id)
    {
        return self::Find("CommitteeMember", "CommitteeMemberID", array(
            "BatchMemberID" => $batch_member_id,
            "CommitteeID" => $committee_id,
            "IsApproved" => true
        ));
    }

    public function AddCommitteeMember(CommitteeMemberModel $member)
    {
        return self::Insert("CommitteeMember", $member);
    }

    public function AddCommitteePermission(CommitteePermissionModel $permission)
    {
        return self::Insert("CommitteePermission", $permission);
    }

    public function RemoveCommitteeMember($batch_member_id)
    {
        return self::Delete(
            "CommitteeMember", "BatchMemberID", $batch_member_id
        );
    }
}
