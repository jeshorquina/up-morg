<?php
namespace Jesh\Operations\Admin;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Operations\Repository\StaticData;

class AccessActionOperations
{
    private $static_data;

    public function __construct()
    {
        $this->static_data = new StaticData;
    }

    public function MatchingPassword($password)
    {
        return Security::CheckPassword(
            $password, $this->static_data->GetAdminPassword()
        );
    }

    public function SetLoggedInState()
    {
        Session::Clear();
        return Session::Set("admin_data", "TRUE");
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }

    public function ValidateLoginData($username, $password)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString("username", $username);
        $validation->CheckString("password", $password);

        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function ExistingUsername($username)
    {
        return (trim(strtoupper($username)) == "ADMIN");
    }
}