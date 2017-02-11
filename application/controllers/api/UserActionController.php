<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Http;

use \Jesh\Models\MemberModel;

class UserActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("UserActionOperations");
    }

    public function Login()
    {
        $username = Http::Request(Http::POST, "username");
        $password = Http::Request(Http::POST, "password");

        $validation = $this->operations->ValidateLoginData($username, $password);

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else 
        {
            if(!$this->operations->ExistingUsername($username))
            {
                Http::Response(Http::UNPROCESSABLE_ENTITY, "Username does not exist!");
            }
            else if(!$this->operations->MatchingPassword($username, $password))
            {
                Http::Response(Http::UNPROCESSABLE_ENTITY, "Password does not match!");
            }
            else 
            {
                $this->operations->SetLoggedInState($username);
                Http::Response(Http::OK, "Successfully logged in.");
            }
        }

        
	}

    public function Logout()
    {
        if($this->operations->SetLoggedOutState())
        {
            Http::Response(HTTP::OK, "Successfully logged out.");
        }
        else 
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, "Something went wrong.");
        }
    }

    public function Signup()
    {
        $first_name      = Http::Request(Http::POST, "first_name");
        $middle_name     = Http::Request(Http::POST, "middle_name");
        $last_name       = Http::Request(Http::POST, "last_name");
        $email           = Http::Request(Http::POST, "email");
        $phone           = Http::Request(Http::POST, "phone");
        $first_password  = Http::Request(Http::POST, "first_password");
        $second_password = Http::Request(Http::POST, "second_password");

        $validation = $this->operations->ValidateRegistrationData(
            array(
                "first_name"      => $first_name,
                "last_name"       => $last_name,
                "email_address"   => $email,
                "phone_number"    => $phone,
                "first_password"  => $first_password,
                "second_password" => $second_password
            )
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else 
        {
            $response = $this->operations->CreateMember(
                new MemberModel(
                    array(
                        "FirstName"    => $first_name,
                        "MiddleName"   => $middle_name,
                        "LastName"     => $last_name,
                        "EmailAddress" => $email,
                        "PhoneNumber"  => $phone,
                        "Password"     => Security::GenerateHash($first_password),
                    )
                )
            );

            if(!$response)
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, "Unable to create new member.");
            }
            else if(!$this->operations->SetLoggedInState($email))
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, "Unable to create session data for log in.");
            }
            else
            {
                Http::Response(Http::CREATED, "Member successfully created.");
            }
        }
    }
}
