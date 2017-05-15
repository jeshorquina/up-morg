<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

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
            Url::Redirect("home/");
        }

        // if no redirection is done
        return true;
    }

    private function SetTemplates()
    {
        self::SetHeader("templates/header.html.inc");
        self::SetHeader("templates/nav.html.inc");
        self::SetFooter("templates/footer.html.inc");
    }

    public function Login()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" =>  "Log In"
                )
            )
        );

        self::SetBody("public/login.html.inc");
        self::RenderView(
            PageRenderer::GetPublicPageData("login", $other_details)
        );
    }

    public function Signup()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" =>  "Sign Up"
                )
            )
        );

        self::SetBody("public/signup.html.inc");
        self::RenderView(
            PageRenderer::GetPublicPageData("signup", $other_details)
        );
    }

    public function Events()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" =>  "MOrg Events"
                )
            )
        );

        self::SetBody("public/events.html.inc");
        self::RenderView(
            PageRenderer::GetPublicPageData("events", $other_details)
        );
    }
}
