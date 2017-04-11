<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\MemberModel;

class PublicPagesActionOperationsRepository extends Repository
{
    public function GetUsernameExists($username)
    {
        return self::Find(
            "Member", 
            "EmailAddress", 
            array(
                "EmailAddress" => $username
            )
        );
    }

    public function GetPassword($username)
    {
        $member_records = self::Get(
            "Member", "Password", array("EmailAddress" => $username)
        );

        if(sizeof($member_records) === 0)
        {
            return null;
        }
        else if(sizeof($member_records) === 1)
        {
            return $member_records[0]["Password"];
        }
        else
        {
            throw new \Exception("There are multiple users with the same email address.");
        }
    }

    public function GetMemberData($username)
    {
        $member_records = self::Get(
            "Member", 
            "MemberID, FirstName, MiddleName, LastName, PhoneNumber", 
            array("EmailAddress" => $username)
        );

        if(sizeof($member_records) === 1)
        {
            return new MemberModel($member_records[0]);
        }
        else
        {
            throw new \Exception("An account with that e-mail address already exists.");
        }
    }

    public function InsertMemberToDatabase(MemberModel $member)
    {
        return self::Insert("Member", $member);
    }
}
