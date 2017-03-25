<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class UserPagesController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(Session::Find("user_data"))
        {
            self::Redirect("home/");
        }
    }

    public function Home()
    {
        self::RenderView(
            "user-pages/home.html.inc", 
            Security::GetCSRFData()
        );
    }
}