<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\CommitteeModel;
use \Jesh\Models\CommitteeMemberModel;
use \Jesh\Models\CommitteePermissionModel;

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

    public function GetApprovedBatchMemberIDs($committee_id)
    {
        $committee_members = $this->repository->GetCommitteeMembers(
            $committee_id
        );

        $ids = array();
        foreach($committee_members as $committee_member) 
        {
            if((bool)$committee_member["IsApproved"] === true)
            {
                $ids[] = $committee_member["BatchMemberID"];
            }
        }
        return $ids;
    }

    public function GetRequestingBatchMemberIDs($committee_id)
    {
        $committee_members = $this->repository->GetCommitteeMembers(
            $committee_id
        );

        $ids = array();
        foreach($committee_members as $committee_member) 
        {
            if((bool)$committee_member["IsApproved"] === false)
            {
                $ids[] = $committee_member["BatchMemberID"];
            }
        }
        return $ids;
    }

    public function GetCommitteePermissionCommitteeIDs(
        $batch_id, $member_type_id
    )
    {
        $committees = $this->repository->GetCommitteePermissionCommitteeID(
            $batch_id, $member_type_id
        );

        $ids = array();
        foreach($committees as $committee)
        {
            $ids[] = $committee["CommitteeID"];
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

    public function IsBatchMemberApproved($batch_member_id)
    {
        return $this->repository->IsBatchMemberApproved($batch_member_id);
    }

    public function IsBatchMemberCommitteeApproved(
        $batch_member_id, $committee_id
    )
    {
        return $this->repository->IsBatchMemberCommitteeApproved(
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

    public function UpdateMember($batch_member_id, CommitteeMemberModel $member)
    {
        $is_updated = $this->repository->UpdateCommitteeMember(
            $batch_member_id, $member
        );

        if(!$is_updated)
        {
            throw new \Exception("Committee member was not updated.");
        }

        return $is_updated;
    }

    public function AddCommitteePermission(CommitteePermissionModel $permission)
    {
        $is_added = $this->repository->AddCommitteePermission($permission);

        if(!$is_added)
        {
            throw new \Exception(
                "Committee permission was not added from the database"
            );
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
