<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class LoggedOutPagesController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
  
        if($this->CheckAccess())
        {
            $this->SetTemplates();
        }
    }

    private function CheckAccess()
    {
        if(Session::Find("user_data"))
        {
            self::Redirect("home/");
        }

        // if no redirection is done
        return true;
    }

    private function SetTemplates()
    {
        self::SetHeader(
            array(
                "public/templates/header.html.inc",
                "public/templates/nav.html.inc"
            )
        );
        self::SetFooter("public/templates/footer.html.inc");
    }

    private function GetNavigationLinks()
    {
        return array(
            array(
                "name" => "Login",
                "url" => self::GetBaseURL('login')
            ),
            array(
                "name" => "Sign Up",
                "url" => self::GetBaseURL('sign-up')
            )
        );
    }

    private function GetPageURLs($stylesheet, $script)
    {
        return array(
            "base" => self::GetBaseURL(),
            "index" => self::GetBaseURL(),
            "stylesheet" => self::GetBaseURL($stylesheet),
            "script" => self::GetBaseURL($script),
        );
    }

    public function Login()
    {
        self::SetBody("public/login.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Log In",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/public/login.css",
                        "public/js/public/login.js"
                    )
                ) 
            )
        ));
    }

    public function Signup()
    {
        self::SetBody("public/signup.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Sign Up",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/public/signup.css",
                        "public/js/public/signup.js"
                    )
                )
            )
        ));
    }
}
