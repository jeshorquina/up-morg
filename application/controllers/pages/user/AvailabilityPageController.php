<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\PermissionHelper;

class AvailabilityPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PermissionHelper::HasUserPageAccess(self::GetBaseURL())) 
        {
            $this->SetTemplates();
        }
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

    public function AvailabilityIndex()
    {
        self::SetBody("user/availability.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Availability Tracker",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/user/availability.css",
                        "public/js/user/availability.js"
                    )
                ) 
            )
        ));
    }
}