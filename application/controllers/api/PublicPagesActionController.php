<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;

use \Jesh\Models\MemberModel;

class PublicPagesActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("PublicPagesActionOperations");
    }

    public function Login()
    {
        $username = Http::Request(Http::POST, "username");
        $password = Http::Request(Http::POST, "password");

        $validation = $this->operations->ValidateLoginData($username, $password);

        if($validation["status"] === false)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                $validation["message"]
            );
        }
        else if(!$this->operations->ExistingUsername($username))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array("username" => "Username does not exist!")
            );
        }
        else if(!$this->operations->MatchingPassword($username, $password))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array("password" => "Password is incorrect. Try again!")
            );
        }
        else 
        {
            $this->operations->SetLoggedInState($username);
            Http::Response(Http::OK, array(
                    "message"      => "Successfully logged in.",
                    "redirect_url" => self::GetBaseURL("home")
                )
            );
        }
	}

    public function Logout()
    {
        if($this->operations->SetLoggedOutState())
        {
            Http::Response(
                HTTP::FOUND,
                "Successfully logged out.",
                "Location: " . self::GetBaseURL()
            );
        }
        else
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, 
                "Something went wrong."
            );
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
                "email"           => $email,
                "phone"           => $phone,
                "first_password"  => $first_password,
                "second_password" => $second_password
            )
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if($this->operations->ExistingUsername($email)) {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                array(
                    "email" => "Email is already registered!",
                )
            );
        }
        else if($first_password !== $second_password) {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                array(
                    "first_password" => "Passwords do not match!",
                    "second_password" => "Passwords do not match!"
                )
            );
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
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, array(
                        "message" => "Unable to create new member."
                    )
                );
            }
            else if(!$this->operations->SetLoggedInState($email))
            {
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, array(
                        "message" => "Unable to create session data for log in."
                    )
                );
            }
            else
            {
                Http::Response(Http::CREATED, array(
                        "message"      => "Member successfully created.",
                        "redirect_url" => self::GetBaseURL("home")
                    )
                );
            }
        }
    }
}
