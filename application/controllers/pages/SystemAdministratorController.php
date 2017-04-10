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

        if($this->CheckAccess()) 
        {
            $this->SetTemplates();
        }
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

        // if no redirection is done
        return true; 
    }

    private function SetTemplates()
    {
        self::SetHeader("admin-pages/templates/header.html.inc");
        self::SetFooter("admin-pages/templates/footer.html.inc");
    }

    private function GetNavigationLinks()
    {
        return array(
            array(
                "name" => "Change Password",
                "url" => self::GetBaseURL('admin/account/password')
            ),
            array(
                "name" => "Manage Batch",
                "url" => self::GetBaseURL('admin/manage/batch')
            ),
            array(
                "name" => "Logout",
                "url" => self::GetBaseURL('action/admin/logout')
            )
        );
    }

    private function GetPageURLs($stylesheet, $script, $index = '')
    {
        return array(
            "base" => self::GetBaseURL(),
            "index" => self::GetBaseURL($index),
            "stylesheet" => self::GetBaseURL($stylesheet),
            "script" => self::GetBaseURL($script),
        );
    }

    public function Login()
    {
        self::SetBody("admin-pages/login.html.inc");
		self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Log In",
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/login.css",
                        "public/js/admin/login.js"
                    )
                )
            )
        ));
    }
    
    public function Home()
    {
        self::SetHeader("admin-pages/templates/nav.html.inc");
        self::SetBody("admin-pages/index.html.inc");
        self::RenderView(
            array(
                "page" => array(
                    "title" => "Admin - Home",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/index.css",
                        "public/js/admin/index.js",
                        "admin"
                    )
                ) 
            )
        );
    }

    public function ChangePassword()
    {
        self::SetHeader("admin-pages/templates/nav.html.inc");
        self::SetBody("admin-pages/change-password.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Change Password",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/password.css",
                        "public/js/admin/password.js",
                        "admin"
                    )
                ) 
            )
        ));
    }

    public function ManageBatch()
    {
        self::SetHeader("admin-pages/templates/nav.html.inc");
        self::SetBody("admin-pages/manage-batch.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Manage Batch",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/admin/batch.js",
                        "admin"
                    )
                ) 
            )
        ));  
    }

}
