<?php
namespace Jesh\Operations\Repository;

use \Jesh\Models\AvailabilityMemberModel;
use \Jesh\Models\AvailabilityGroupModel;
use \Jesh\Models\AvailabilityGroupMemberModel;

use \Jesh\Repository\AvailabilityOperationsRepository;

class AvailabilityOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AvailabilityOperationsRepository;
    }

    public function GetAvailabilityByBatchMemberID($batch_member_id)
    {
        $availability = (
            $this->repository->GetAvailabilityByBatchMemberID($batch_member_id)
        );

        if(sizeof($availability) === 1)
        {
            return new AvailabilityMemberModel($availability[0]);
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    "No availability record for batch member id = %s found",
                    $batch_member_id
                )
            );
        }
    }
    
    public function GetAvailabilityByMemberID($member_id)
    {
        $availability = (
            $this->repository->GetAvailabilityByMemberID($member_id)
        );
        if(sizeof($availability) === 1)
        {
            return new AvailabilityMemberModel($availability[0]);
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    "No availability member record with id = %s found",
                    $member_id
                )
            );
        }
    }

    public function GetGroup($group_id)
    {
        $group = $this->repository->GetGroup($group_id);
        if(sizeof($group) === 1)
        {
            return new AvailabilityGroupModel($group[0]);
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    "No availability group record with id = %s found",
                    $group_id
                )
            );
        }
    }

    public function GetGroups($frontman_id)
    {
        $groups = array();
        foreach($this->repository->GetGroups($frontman_id) as $group)
        {
            $groups[] = new AvailabilityGroupModel($group);
        }
        return $groups;
    }

    public function GetGroupMembers($group_id)
    {
        $members = array();
        foreach($this->repository->GetGroupMembers($group_id) as $member)
        {
            $members[] = new AvailabilityGroupMemberModel($member);
        }
        return $members;
    }

    public function GetGroupMemberID($group_id, $member_id)
    {
        $group_member_id = $this->repository->GetGroupMemberID(
            $group_id, $member_id
        );
        if(sizeof($group_member_id) === 1)
        {
            return $group_member_id[0]["AvailabilityGroupMemberID"];
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    StringHelper::NoBreakString(
                        "No availability group member record with group id = %s 
                        and member id = %s found"   
                    ), $group_id, $member_id
                )
            );
        }
    }

    public function GetMemberIDs($group_id)
    {
        $member_ids = array();
        foreach($this->GetGroupMembers($group_id) as $member)
        {
            $member_ids[] = $member->AvailabilityMemberID;
        }
        return $member_ids;
    }

    public function HasAvailability($member_id)
    {
        return $this->repository->HasAvailability($member_id);
    }

    public function HasGroupMember($group_id, $member_id)
    {
        return $this->repository->HasGroupMember($group_id, $member_id);
    }

    public function AddAvailability($batch_member_id)
    {
        $is_added =  $this->repository->AddAvailability(
            new AvailabilityMemberModel(
                array(
                    "BatchMemberID" => $batch_member_id
                )
            )
        );

        if(!$is_added)
        {
            throw new \Exception(
                "Cound not add batch member availability to the database"
            );
        }

        return $is_added;
    }

    public function AddGroup(AvailabilityGroupModel $group)
    {
        $is_added =  $this->repository->AddGroup($group);

        if(!$is_added)
        {
            throw new \Exception(
                "Cound not add availability group to the database."
            );
        }

        return $is_added;
    }

    public function AddGroupMember(AvailabilityGroupMemberModel $group_member) 
    {
        $is_added =  $this->repository->AddGroupMember($group_member);

        if(!$is_added)
        {
            throw new \Exception(
                "Cound not add availability group member to the database."
            );
        }

        return $is_added;
    }

    public function UpdateAvailability(
        $batch_member_id, AvailabilityMemberModel $availability
    ) {
        $is_updated = $this->repository->UpdateAvailability(
            $batch_member_id, $availability
        );

        if(!$is_updated)
        {
            throw new \Exception(
                sprintf(
                    "Cound not update availability of batch member id = %s",
                    $batch_member_id
                )
            );
        }

        return $is_updated;
    }

    public function DeleteGroup($group_id)
    {
        $is_deleted = $this->repository->DeleteGroup($group_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                "Cound not delete availability group to the database"
            );
        }

        return $is_deleted;
    }

    public function DeleteGroupMember($group_member_id)
    {
        $is_deleted = $this->repository->DeleteGroupMember($group_member_id);

        if(!$is_deleted)
        {
            throw new \Exception(
                "Cound not delete availability group member to the database"
            );
        }

        return $is_deleted;
    }
}
