<?php
namespace Jesh\Repository;

use \Jesh\Models\MemberModel;

use \Jesh\Core\Wrappers\Repository;

class MemberOperationsRepository extends Repository
{
    public function GetMembers()
    {
        return self::Get(
            "Member", "MemberID, FirstName, MiddleName, LastName"
        );
    }
    
    public function GetMember($member_id)
    {
        return self::Get(
            "Member", "*", array("MemberID" => $member_id)
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

    public function GetMemberTypeID($member_type)
    {
        return self::Get(
            "MemberType", "MemberTypeID", array("MemberType" => $member_type)
        );
    }

    public function GetMemberIDByEmailAddress($email_address)
    {
        return self::Get(
            "Member", "MemberID", array("EmailAddress" => $email_address)
        );
    }

    public function GetMemberPasswordByEmail($email_address)
    {
        return self::Get(
            "Member", "Password", array("EmailAddress" => $email_address)
        );
    }

    public function HasMember($member_id)
    {
        return self::Find("Member", "MemberID", array(
            "MemberID" => $member_id
        ));
    }

    public function HasEmailAddress($email_address)
    {
        return self::Find("Member", "MemberID", array(
            "EmailAddress" => $email_address
        ));
    }

    public function InsertMember(MemberModel $member)
    {
        return self::Insert("Member", $member);
    }

    public function UpdateMember($member_id, MemberModel $member)
    {
        return self::Update("Member", array("MemberID" => $member_id), $member);
    }

    public function DeleteMemberByID($member_id)
    {
        return self::Delete("Member", "MemberID", $member_id);
    }
}
