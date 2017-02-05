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

    public function index()
    {
		self::RenderView("public-pages/index.html.inc");
    }

    public function Login()
    {
        self::RenderView(
            "public-pages/login.html.inc", 
            Security::GetCSRFData()
        );
    }

    public function Signup()
    {
        self::RenderView(
            "public-pages/signup.html.inc", 
            Security::GetCSRFData()
        );
    }
}
