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
    }

    public function Login()
    {
        self::SetBody("public-pages/login.html.inc");
        self::RenderView(Security::GetCSRFData());
    }

    public function Signup()
    {
        self::SetBody("public-pages/signup.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}
