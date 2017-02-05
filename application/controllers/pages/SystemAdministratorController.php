<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class SystemAdministratorController extends Controller
{
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

    public function ManageBatch()
    {
        self::RenderView(
            "admin-pages/managebatch.html.inc", 
            array(
                "hi" => "hello"
            )
        );
    }
}
