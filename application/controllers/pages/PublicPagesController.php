<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class PublicPagesController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
  
        if(Session::Find("user_data"))
        {
            self::Redirect("home/");
        }

        self::SetHeader(
            array(
                "public-pages/templates/header.html.inc",
                "public-pages/templates/nav.html.inc"
            )
        );
        self::SetFooter("public-pages/templates/footer.html.inc");
    }

    public function Login()
    {
        self::SetBody("public-pages/login.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Log In"
                ) 
            )
        ));
    }

    public function Signup()
    {
        self::SetBody("public-pages/signup.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Sign Up"
                )
            )
        ));
    }
}
