<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Http;

use \Jesh\Models\MemberModel;
use \Jesh\Repository\UserActionOperationsRepository;

class UserActionOperations {

    private static $repository;

    public function __construct()
    {
        self::$repository = new UserActionOperationsRepository;
    }

    public function ExistingUsername($username)
    {
        return self::$repository->GetUsernameExists($username);
    }

    public function MatchingPassword($username, $password) 
    {
        return Security::CheckPassword($password, self::$repository->GetPassword($username));
    }
    
    public function ValidateRegistrationData($first_name, $middle_name, $last_name, 
                                            $email_address, $phone_number, 
                                            $first_password, $second_password)
    {
        $first_name         = filter_var($first_name, FILTER_SANITIZE_STRING);
        $middle_name        = filter_var($middle_name, FILTER_SANITIZE_STRING);
        $last_name          = filter_var($last_name, FILTER_SANITIZE_STRING);
        $email_address      = filter_var($email_address, FILTER_SANITIZE_EMAIL);
        $phone_number       = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
        $first_password     = filter_var($first_password, FILTER_SANITIZE_STRING);
        $second_password    = filter_var($second_password, FILTER_SANITIZE_STRING);

        $validation_array = array();
        $validation_array["status"] = true;

        if(strlen($first_name) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["first_name"] = "Empty first name.";
        }

        if(strlen($last_name) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["last_name"] = "Empty last name.";
        }

        if(strlen($email_address) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["email_address"] = "Empty email address.";
        }

        if(strlen($phone_number) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["phone_number"] = "Empty phone number.";
        }

        if(strlen($first_password) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["first_password"] = "Empty password.";
        }

        if(strlen($second_password) === 0)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["second_password"] = "Empty confirm password.";
        }
        
        if(!filter_var($email_address, FILTER_VALIDATE_EMAIL))
        {
            $validation_array["status"] = false;
            $validation_array["data"]["email_address"] = "Invalid email.";
        }

        if($first_password !== $second_password)
        {
            $validation_array["status"] = false;
            $validation_array["data"]["password"] = "Passwords do not match.";
        }

       // $validation_array["data"] = json_encode($validation_array["data"]);
        return $validation_array;
    }

    public function CreateMember(MemberModel $member)
    {
        if(self::$repository->InsertMemberToDatabase($member))
        {
            return array(
                "status" => Http::CREATED,
                "message" => "Member successfully created."
            );
        }
        else 
        {
            return array(
                "status" => Http::INTERNAL_SERVER_ERROR,
                "message" => "Member has not been created."
            );
        }
    }
}
