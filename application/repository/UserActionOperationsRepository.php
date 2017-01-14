<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\MemberModel;

class UserActionOperationsRepository extends Repository {

    public function GetUsernameExists($username)
    {
        return self::Find("Member", "EmailAddress", $username);
    }

    public function GetPassword($username)
    {
        $array = self::Get("Member", "Password", array("EmailAddress" => $username));
        if(sizeof($array) === 1)
        {
            return $array[0]["Password"];
        }
        else
        {
            return null;
        }
    }

    public function InsertMemberToDatabase(MemberModel $member)
    {
        return self::Insert("Member", $member);
    }
}
