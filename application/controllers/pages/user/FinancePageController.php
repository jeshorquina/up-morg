<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class FinancePageController extends Controller 
{public function __construct()
    {
        parent::__construct();

        if($this->CheckAccess()) 
        {
            $this->SetTemplates();
        }
    }

    private function CheckAccess()
    {
        if(!Session::Find("user_data"))
        {
            self::Redirect();
        }

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
                "name" => "Task Manager",
                "url" => self::GetBaseURL('task')
            ),
            array(
                "name" => "Availability Tracker",
                "url" => self::GetBaseURL('availability')
            ),
            array(
                "name" => "Calendar",
                "url" => self::GetBaseURL('calendar')
            ),
            array(
                "name" => "Finance tracker",
                "url" => self::GetBaseURL('finance')
            ),
            array(
                "name" => "Logout",
                "url" => self::GetBaseURL('action/logout')
            )
        );
    }

    private function GetPageURLs($stylesheet, $script)
    {
        return array(
            "base" => self::GetBaseURL(),
            "index" => self::GetBaseURL(),
            "stylesheet" => self::GetBaseURL($stylesheet),
            "script" => self::GetBaseURL($script),
        );
    }

    public function FinanceIndex()
    {
        self::SetBody("user/finance.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Finance Tracker",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/user/finance.css",
                        "public/js/user/finance.js"
                    )
                ) 
            )
        ));  
    }
}