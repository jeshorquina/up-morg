<?php
namespace Jesh\Operations\User;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;

use \Jesh\Operations\Repository\Member;

class UserAccountActionOperations
{
    private $static_data;

    public function __construct()
    {
        $this->member = new Member;
    }

    public function ValidateUpdatePasswordData($input_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($input_data as $name => $value) 
        {
            if(strtolower(gettype($value)) === "string")
            {
                $validation->CheckString($name, $value);
            }
        }
        
        return array(
            "status" => $validation->GetStatus(),
            "data"   => $validation->GetValidationData()
        );
    }

    public function MatchingPassword($member_id, $password)
    {
        return Security::CheckPassword(
            $password, $this->member->GetMember($member_id)->Password
        );
    }

    public function ChangePassword($member_id, $password)
    {
        return $this->member->Update($member_id,
            new MemberModel(
                array("Password" => Security::GenerateHash($password))
            )
        );
    }
}