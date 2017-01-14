<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Http;

use \Jesh\Models\MemberModel;
use \Jesh\Operations\UserActionOperations;

class UserActionController extends Controller {

    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new UserActionOperations;
    }

	public function Login()
	{
        $username = Http::Request(Http::POST, "username");
        $password = Http::Request(Http::POST, "password");

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
            Http::Response(Http::OK, "Logged in!");
        }
	}

    public function Signup()
    {
        $first_name         = Http::Request(Http::POST, "first_name");
        $middle_name        = Http::Request(Http::POST, "middle_name");
        $last_name          = Http::Request(Http::POST, "last_name");
        $email              = Http::Request(Http::POST, "email");
        $phone              = Http::Request(Http::POST, "phone");
        $first_password     = Http::Request(Http::POST, "first_password");
        $second_password    = Http::Request(Http::POST, "second_password");

        $validation = $this->operations->ValidateRegistrationData(
            $first_name, $middle_name, $last_name, 
            $email, $phone, $first_password, $second_password
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else 
        {
            $response = $this->operations->CreateMember(
                new MemberModel(
                    $first_name, 
                    $middle_name, 
                    $last_name, 
                    $email,
                    $phone,
                    Security::GenerateHash($first_password)
                )
            );
            Http::Response($response["status"], $response["message"]);
        }
    }
}
