<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\AvailabilityMemberModel;
use \Jesh\Models\AvailabilityGroupModel;
use \Jesh\Models\AvailabilityGroupMemberModel;

class AvailabilityRepository extends Repository
{
    public function GetAvailabilityByBatchMemberID($batch_member_id)
    {
        return self::Get("AvailabilityMember", "*", 
            array("BatchMemberID" => $batch_member_id)
        );
    }

    public function GetAvailabilityByMemberID($availability_member_id)
    {
        return self::Get("AvailabilityMember", "*", 
            array("AvailabilityMemberID" => $availability_member_id)
        );
    }

    public function GetGroup($group_id)
    {
        return self::Get(
            "AvailabilityGroup", "*", array("AvailabilityGroupID" => $group_id)
        );
    }

    public function GetGroups($frontman_id)
    {
        return self::Get(
            "AvailabilityGroup", "*", array("FrontmanID" => $frontman_id)
        );
    }

    public function GetGroupMembers($group_id)
    {
        return self::Get(
            "AvailabilityGroupMember", "*", 
            array("AvailabilityGroupID" => $group_id)
        );
    }

    public function GetGroupMemberID($group_id, $member_id)
    {
        return self::Get(
            "AvailabilityGroupMember", "AvailabilityGroupMemberID", 
            array(
                "AvailabilityGroupID" => $group_id,
                "AvailabilityMemberID" => $member_id
            )
        );
    }

    public function HasAvailability($member_id)
    {
        return self::Find("AvailabilityMember", "AvailabilityMemberID", 
            array("AvailabilityMemberID" => $member_id)
        );
    }

    public function HasGroupMember($group_id, $member_id)
    {
        return self::Find(
            "AvailabilityGroupMember", "AvailabilityGroupMemberID", 
            array(
                "AvailabilityGroupID" => $group_id,
                "AvailabilityMemberID" => $member_id
            )
        );
    }

    public function AddAvailability(AvailabilityMemberModel $availability)
    {
        return self::Insert("AvailabilityMember", $availability);
    }

    public function AddGroup(AvailabilityGroupModel $group)
    {
        return self::Insert("AvailabilityGroup", $group);
    }

    public function AddGroupMember(AvailabilityGroupMemberModel $group_member)
    {
        return self::Insert("AvailabilityGroupMember", $group_member);
    }

    public function UpdateAvailability(
        $batch_member_id, AvailabilityMemberModel $availability
    ) {
        return self::Update("AvailabilityMember", array(
            "BatchMemberID" => $batch_member_id
        ), $availability);
    }

    public function DeleteGroup($group_id)
    {
        return self::Delete(
            "AvailabilityGroup", "AvailabilityGroupID", $group_id
        );
    }

    public function DeleteGroupMember($group_member_id)
    {
        return self::Delete(
            "AvailabilityGroupMember", 
            "AvailabilityGroupMemberID", $group_member_id
        );
    }
}