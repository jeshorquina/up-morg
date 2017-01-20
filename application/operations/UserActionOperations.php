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

    public function ValidateLoginData($email_address, $password)
    {
        $email_address = filter_var($email_address, FILTER_SANITIZE_EMAIL);
        $password      = filter_var($password, FILTER_SANITIZE_STRING);

        $validation_array = array();
        $validation_array["status"] = true;

        if(strlen($email_address) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["email_address"] = "Empty username.";
        } 

        if(strlen($email_address) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["password"] = "Empty password.";
        }      

        if(!filter_var($email_address, FILTER_VALIDATE_EMAIL))
        {
            $validation_array["status"] = false;
            $validation_array["data"]["email_address"] = "Invalid username. Please enter your registered email address.";
        }

        return $validation_array;
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
