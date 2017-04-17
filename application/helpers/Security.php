<?php 
namespace Jesh\Helpers;

use \CI_Security;

class Security
{  
    public static function GenerateHash($input)
    {
        return password_hash($input, PASSWORD_BCRYPT);
    }

    public static function CheckPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public static function GetCSRFData()
    {
        $ci_security = new CI_Security;
        return array(
            'csrf' => array(
                'name' => $ci_security->get_csrf_token_name(),
                'hash' => $ci_security->get_csrf_hash()
            )
        );
        unset($ci_security);
    }
}
