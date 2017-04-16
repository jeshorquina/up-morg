<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\CommitteeModel;
use \Jesh\Models\CommitteeMemberModel;

use \Jesh\Repository\CommitteeOperationsRepository;

class CommitteeOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CommitteeOperationsRepository;
    }

    public function GetCommittees()
    {
        $committees = array();
        foreach($this->repository->GetCommittees() as $committee)
        {
            $committees[] = new CommitteeModel($committee);
        }
        return $committees;
    }

    public function GetCommitteeIDByCommitteeName($committee_name)
    {
        $committee = $this->repository->GetCommitteeIDByCommitteeName(
            $committee_name
        );

        if(sizeof($committee) === 1)
        {
            return $committee[0]["CommitteeID"];
        }
        else
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee with committee name = %s was not found in 
                        the database"
                    ), $committee_name
                )
            );
        }
    }

    public function GetCommitteeIDByBatchMemberID($batch_member_id)
    {
        $committee = $this->repository->GetCommitteeIDByBatchMemberID(
            $batch_member_id
        );

        if(sizeof($committee) === 1)
        {
            return $committee[0]["CommitteeID"];
        }
        else
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee ID of batch member id = %s was not found in 
                        the database"
                    ), $batch_member_id
                )
            );
        }
    }

    public function GetCommitteeName($committee_id)
    {
        $committee = $this->repository->GetCommitteeName($committee_id);

        if(sizeof($committee) === 1) 
        {
            return $committee[0]["CommitteeName"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee for committee id = %s was not found in 
                        the database"
                    ), $committee_id
                )
            );
        }
    }

    public function GetCommitteeMemberID($batch_member_id)
    {
        $committee_member = $this->repository->GetCommitteeMemberID(
            $batch_member_id
        );

        if(sizeof($committee_member) === 1)
        {
            return $committee_member[0]["CommitteeMemberID"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee member with batch member id = %s was not 
                        found in the database"
                    ), $batch_member_id
                )
            );
        }
    }

    public function GetBatchMemberIDs($committee_id)
    {
        $batch_member_ids = $this->repository->GetBatchMemberIDs(
            $committee_id
        );

        $ids = array();
        foreach($batch_member_ids as $batch_member_id) 
        {
            $ids[] = $batch_member_id["BatchMemberID"];
        }
        return $ids;
    }

    public function HasCommitteeName($committee_name)
    {
        return $this->repository->HasCommitteeName($committee_name);
    }

    public function HasBatchMember($batch_member_id)
    {
        return $this->repository->HasBatchMember($batch_member_id);
    }

    public function IsBatchMemberInCommittee($batch_member_id, $committee_id)
    {
        return $this->repository->IsBatchMemberInCommittee(
            $batch_member_id, $committee_id
        );
    }

    public function AddMember(CommitteeMemberModel $member)
    {
        $is_added = $this->repository->AddCommitteeMember($member);

        if(!$is_added)
        {
            throw new \Exception("Committee member was not aded to database.");
        }

        return $is_added;
    }

    public function RemoveCommitteeMember($batch_member_id)
    {
        $is_removed = $this->repository->RemoveCommitteeMember(
            $batch_member_id
        );

        if(!$is_removed)
        {
            throw new \Exception(
               sprintf(
                    NoBreakString::NoBreakString(
                        "Committee Member with batch member id = %s was 
                        not removed from the database"
                    ), $batch_member_id
               )
            );
        }

        return $is_removed;
    }
}
