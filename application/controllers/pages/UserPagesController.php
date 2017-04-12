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

        if($this->CheckAccess()) 
        {
            $this->SetTemplates();
        }
    }

    private function CheckAccess()
    {
        if(!Session::Find("user_data"))
        {
            self::Redirect("/");
        }
        return true;
    }

    private function SetTemplates()
    {
        self::SetHeader("user-pages/templates/header.html.inc");
        self::SetHeader("user-pages/templates/nav.html.inc");
        self::SetFooter("user-pages/templates/footer.html.inc");
    }

    private function GetNavigationLinks()
    {
        return array(
            array(
                "name" => "Home",
                "url" => self::GetBaseURL('home')
            ),
            array(
                "name" => "Task Manager",
                "url" => self::GetBaseURL('task-manager')
            ),
            array(
                "name" => "Availability Tracker",
                "url" => self::GetBaseURL('availability-tracker')
            ),
            array(
                "name" => "Calendar",
                "url" => self::GetBaseURL('calendar')
            ),
            array(
                "name" => "Finance Tracker",
                "url" => self::GetBaseURL('finance-tracker')
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

    public function TaskManager()
    {
        self::SetBody("user-pages/task-manager.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Task Manager",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/user-pages/task.js"
                    )
                ) 
            )
        ));  
    }

    public function Home()
    {
        self::SetBody("user-pages/home.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Home",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        ""
                    )
                ) 
            )
        ));  
    }

    public function AvailabilityTracker()
    {
        self::SetBody("user-pages/availability-tracker.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Availability Tracker",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/user-pages/availability.js"
                    )
                ) 
            )
        ));  
    }

    public function Calendar()
    {
        self::SetBody("user-pages/calendar.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Calendar",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/user-pages/calendar.js"
                    )
                ) 
            )
        ));  
    }

    public function FinanceTracker()
    {
        self::SetBody("user-pages/finance-tracker.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Finance Tracker",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/user-pages/finance.js"
                    )
                ) 
            )
        ));  
    }
}
