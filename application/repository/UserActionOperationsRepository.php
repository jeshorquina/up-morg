<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;
use \Jesh\Models\MemberModel;

class UserActionOperationsRepository extends Repository {

    public function GetIsUsernameExists($username)
    {
        return self::Find("Member", "EmailAddress", $username);
    }

    public function GetPassword($username)
    {
        return self::Get("Member", "Password", array("EmailAddress" => $username))[0]["Password"];
    }

    public function InsertMemberToDatabase(MemberModel $member)
    {
        self::Insert("Member", $member);
    }
}
