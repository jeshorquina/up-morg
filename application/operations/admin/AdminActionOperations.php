<?php
namespace Jesh\Operations\Admin;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Operations\Helpers\StaticDataOperations;

class AdminActionOperations
{
    private $static_data;

    public function __construct()
    {
        $this->static_data = new StaticDataOperations;
    }

    public function SetLoggedInState()
    {
        return Session::Set("admin_data", "TRUE");
    }

    public function SetLoggedOutState()
    {
        return Session::End();
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

    public function MatchingPassword($password)
    {
        $db_password = $this->static_data->GetPassword();

        if(sizeof($db_password) === 1)
        {
            return Security::CheckPassword($password, $db_password[0]["Value"]);
        }
        else 
        {
            throw new \Exception("No record for system admin password found");
        }
        
    }

    public function ChangePassword($password)
    {
        return $this->static_data->ChangePassword(
            Security::GenerateHash($password)
        );
    }
}