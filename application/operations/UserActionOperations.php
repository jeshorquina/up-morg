<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;
use \Jesh\Repository\UserActionOperationsRepository;

class UserActionOperations {

    private $repository;

    public function __construct()
    {
        $this->repository = new UserActionOperationsRepository;
    }

    public function ExistingUsername($username)
    {
        return $this->repository->GetUsernameExists($username);
    }

    public function MatchingPassword($username, $password) 
    {
        return Security::CheckPassword($password, self::$repository->GetPassword($username));
    }
    
    public function ValidateRegistrationData($registration_data)
    {
        $validation = new ValidationDataBuilder;

        foreach($registration_data as $name => $value) 
        {
            if(strtolower(gettype($value)) === "string") 
            {
                $validation->CheckString($name, $value);
            }
            if($name === "email_address") 
            {
                $validation->CheckEmail($name, $value);
            }
        }
        
        return array(
            "status" => $validation->GetStatus(),
            "data"   => $validation->GetValidationData()
        );
    }

    public function CreateMember(MemberModel $member)
    {
        if($this->repository->InsertMemberToDatabase($member))
        {
            return array(
                "status" => true,
                "data" => "Member has been successfully created."
            );
        }
        else
        {
            return array(
                "status" => false,
                "data" => "Member has not been successfully created."
            );
        }
    }
}
