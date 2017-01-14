<?php 
namespace Jesh\Helpers;

Class Security {
    
    public static function GenerateHash($input)
    {
        return password_hash($input, PASSWORD_BCRYPT);
    }

    public static function CheckPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}

