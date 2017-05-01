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
}