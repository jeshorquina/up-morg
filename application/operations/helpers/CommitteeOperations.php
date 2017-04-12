<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\CommitteeMemberModel;

use \Jesh\Operations\Helpers\BatchMemberOperations;

use \Jesh\Repository\Helpers\CommitteeOperationsRepository;

class CommitteeOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CommitteeOperationsRepository;
    }

    public function GetCommittees()
    {
        return $this->repository->GetCommittees();
    }

    public function HasCommitteeName($committee_name)
    {
        return $this->repository->HasCommitteeName($committee_name);
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

    public function GetCommitteeNameByBatchMemberID($batch_member_id)
    {
        $committee = $this->repository->GetCommitteeNameByBatchMemberID(
            $batch_member_id
        );

        if(sizeof($committee) === 1) 
        {
            return $committee[0]["CommitteeName"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "Committee for batch member id = %s was not found in 
                        the database"
                    ), $member_type_id
                )
            );
        }
    }

    public function HasBatchMemberID($batch_member_id)
    {
        return $this->repository->HasBatchMemberID($batch_member_id);
    }

    public function HasBatchMemberIDAndCommitteeID(
        $batch_member_id, $committee_id
    )
    {
        return $this->repository->HasBatchMemberIDAndCommitteeID(
            $batch_member_id, $committee_id
        );
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

    public function AddMember(CommitteeMemberModel $member)
    {
        if(!$this->repository->AddCommitteeMember($member))
        {
            throw new \Exception(
                "Committee member was not aded to database."
            );
        }
    }

    public function RemoveMemberByCommitteeMemberID($committee_member_id)
    {
        return $this->repository->RemoveMemberByCommitteeMemberID(
            $committee_member_id
        );
    }

    public function RemoveMemberByBatchMemberID($batch_member_id)
    {
        return $this->repository->RemoveMemberByBatchMemberID(
            $batch_member_id
        );
    }

    public function GetBatchMemberIDArrayByCommitteeID($committee_id)
    {
        $batch_member_ids = (
            $this->repository->GetBatchMemberIDArrayByCommitteeID(
                $committee_id
            )
        );

        $ids = array();
        foreach($batch_member_ids as $batch_member_id) 
        {
            $ids[] = $batch_member_id["BatchMemberID"];
        }
        return $ids;
    }
}
