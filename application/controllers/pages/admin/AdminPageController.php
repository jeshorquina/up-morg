<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class AdminPageController extends Controller
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
                self::Redirect("admin");
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
        self::SetHeader("admin/templates/header.html.inc");
        self::SetHeader("admin/templates/nav.html.inc");
        self::SetFooter("admin/templates/footer.html.inc");
    }

    private function GetNavigationLinks()
    {
        return array(
            array(
                "name" => "Manage Batch",
                "url" => self::GetBaseURL('admin/batch')
            ),
            array(
                "name" => "Manage Members",
                "url" => self::GetBaseURL('admin/member')
            ),
            array(
                "name" => "Change Password",
                "url" => self::GetBaseURL('admin/account/password')
            ),
            array(
                "name" => "Logout",
                "url" => self::GetBaseURL('action/admin/logout')
            )
        );
    }

    private function GetPageURLs($stylesheet, $script)
    {
        return array(
            "base" => self::GetBaseURL(),
            "index" => self::GetBaseURL("admin"),
            "stylesheet" => self::GetBaseURL($stylesheet),
            "script" => self::GetBaseURL($script),
        );
    }

    public function Login()
    {
        self::SetBody("admin/login.html.inc");
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
        self::Redirect("admin/batch");
    }

    public function ChangePassword()
    {
        self::SetBody("admin/change-password.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Change Password",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/password.css",
                        "public/js/admin/password.js"
                    )
                ) 
            )
        ));
    }
}
