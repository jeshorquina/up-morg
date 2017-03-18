<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class SystemAdministratorController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->CheckAccess();
    }

    private function CheckAccess()
    {
        if(uri_string() === "admin/login") 
        {
            if(Session::Find("admin_data"))
            {
                self::Redirect("admin/home");
            }
        }
        else 
        {
            if(!Session::Find("admin_data"))
            {
                self::Redirect("admin/login");
            }
        }
    }

    public function Access()
    {
        self::SetBody("admin-pages/login.html.inc");
		self::RenderView(Security::GetCSRFData());
    }

    public function EditPassword()
    {
        self::SetBody("admin-pages/editpassword.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
    
    public function Home()
    {
        self::SetBody("admin-pages/index.html.inc");
        self::RenderView();
    }

    public function ManageBatch()
    {
        self::SetBody("admin-pages/managebatch.html.inc");
        self::RenderView(Security::GetCSRFData());  
    }

}
