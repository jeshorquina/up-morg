<?php
namespace Jesh\Operations;

use \Jesh\Repository\UserActionOperationsRepository;

class UserActionOperations {

    private static $repository;

    public function __construct()
    {
        self::$repository = new UserActionOperationsRepository;
    }

    public function ExistingUsername($username)
    {
        return self::$repository->GetIsUsernameExists($username);
    }

    public function MatchingPassword($username, $password) 
    {   
        return self::$repository->GetPassword($username) === $password;
    }
    
    public function IsRegistrationDataValid($first_name, $middle_name, $last_name, 
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

        if(!filter_var($email_address, FILTER_VALIDATE_EMAIL))
        {
            return false;
        }

        if($first_password !== $second_password)
        {
            return false;
        }

        return true;
    }
}
