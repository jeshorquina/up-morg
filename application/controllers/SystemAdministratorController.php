<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class SystemAdministratorController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("SystemAdministratorOperations");
    }

    public function Access()
    {
		self::RenderView(
            "admin-pages/login.html.inc",
            Security::GetCSRFData()
            );
    }

    public function EditPassword()
    {
        self::RenderView(
            "admin-pages/editpassword.html.inc",
            Security::GetCSRFData()
            );
    }
    
    public function Home()
    {
        self::RenderView("admin-pages/index.html.inc");
    }

    public function Login()
    {
        $password = Http::Request(Http::POST, "password");
        if(!$this->operations->MatchingPassword($password))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, "Password does not match!");
        }
        else 
        {
            Http::Response(Http::OK, "Successfully logged in.");
        }
    }

    public function ManageBatch()
    {
        self::RenderView("admin-pages/managebatch.html.inc");
    }

    public function UpdatePassword()
    {
        $old_password     = Http::Request(Http::POST, "old_password");
        $new_password     = Http::Request(Http::POST, "new_password");
        $confirm_password = Http::Request(Http::POST, "confirm_password");

         $validation = $this->operations->ValidateInput(
            array(
                "old_password" => $old_password,
                "new_password" => $new_password,
                "confirm_password" => $confirm_password,
            )    
        );
        
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else if($new_password !== $confirm_password)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, "New password does not match confirm password!");
        }
        //else if(!$this->operations->MatchingPassword($old_password))
        //{
        //    Http::Response(Http::UNPROCESSABLE_ENTITY, "Entered old password does not match password in record.");
        //}
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, "Password change has not been changed.");
        }
        else 
        {
            Http::Response(Http::OK, "Password has successfully been changed.");
        }
    }
}