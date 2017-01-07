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
}
