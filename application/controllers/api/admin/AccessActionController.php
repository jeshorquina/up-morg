<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Url;

use \Jesh\Operations\Admin\AccessActionOperations;

class AccessActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new AccessActionOperations;
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
        else if(!$this->operations->MatchingPassword($password))
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
                    "redirect_url" => Url::GetBaseURL('admin')
                )
            );
        }
    }

    public function Logout()
    {
        if(!$this->operations->SetLoggedOutState())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Cannot log out. Please try again."
                )
            );
        }
        else
        {
            Http::Response(
                Http::FOUND, array(
                    "message" => "Successfully logged out."
                ),
                "Location: " . Url::GetBaseURL('admin')
            );
        }
    }
}