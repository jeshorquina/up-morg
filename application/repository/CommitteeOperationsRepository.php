<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\CommitteeMemberModel;

class CommitteeOperationsRepository extends Repository
{
    public function GetCommittees()
    {
        return self::Get("Committee", "CommitteeID, CommitteeName");
    }

    public function HasCommitteeName($committee_name)
    {
        return self::Find("Committee", "CommitteeName", array(
            "CommitteeName" => $committee_name
        ));
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

    public function GetCommitteeNameByBatchMemberID($batch_member_id)
    {
        $committee_id = $this->GetCommitteeIDByBatchMemberID($batch_member_id);

        if(sizeof($committee_id) === 1) 
        {
            return self::Get(
                "Committee", "CommitteeName", array(
                    "CommitteeID" => $committee_id[0]["CommitteeID"]
                )
            );
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee id for batch member id = %s was not found in 
                        the database"
                    ), $batch_member_id
                )
            );
        }
    }

    public function HasBatchMemberID($batch_member_id)
    {
        return self::Find("CommitteeMember", "BatchMemberID", array(
            "BatchMemberID" => $batch_member_id
        ));
    }
    
    public function HasBatchMemberIDAndCommitteeID(
        $batch_member_id, $committee_id
    )
    {
          return self::Find("CommitteeMember", "BatchMemberID", array(
            "BatchMemberID" => $batch_member_id,
            "CommitteeID" => $committee_id
        ));
    }

    public function GetCommitteeMemberID($batch_member_id)
    {
        return self::Get("CommitteeMember", "CommitteeMemberID", array(
            "BatchMemberID" => $batch_member_id
        ));
    }

    public function AddCommitteeMember(CommitteeMemberModel $member)
    {
        return self::Insert("CommitteeMember", $member);
    }

    public function RemoveMemberByCommitteeMemberID($committee_member_id)
    {
        return self::Delete(
            "CommitteeMember", "CommitteeMemberID", $committee_member_id
        );
    }

    public function RemoveMemberByBatchMemberID($batch_member_id)
    {
        return self::Delete(
            "CommitteeMember", "BatchMemberID", $batch_member_id
        );
    }

    public function GetBatchMemberIDArrayByCommitteeID($committee_id)
    {
        return self::Get(
            "CommitteeMember", "BatchMemberID", array(
                "CommitteeID" => $committee_id
            )
        );
    }
}
