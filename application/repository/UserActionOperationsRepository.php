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

    public function UpdateMemberInDatabase($member_id)
    {
        $data = array(
            'FirstName'     => $this->input->post('FirstName'),
            'MiddleName'    => $this->input->post('MiddleName'),
            'LastName'      => $this->input->post('LastName'),
            'EmailAddress'  => $this->input->post('EmailAddress'),
            'PhoneNumber'   => $this->input->post('PhoneNumber'),
            'Password'      => $this->input->post('Password')
        );
        return self::Update("Member", "MemberID", $member_id, $data);
    }

    public function DeleteMemberFromDatabase($member_id)
    {
        return self::Delete("Member", "MemberID", $member_id);
    }
}
