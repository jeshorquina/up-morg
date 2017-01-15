<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;

class PublicPagesController extends Controller {

    public function __construct()
    {
        parent::__construct();
        
        // if logged in
            // redirect to the logged in homepage route
        // end if
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
