<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\StringHelper;

class MemberPageController extends Controller
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
        self::SetHeader("admin-pages/templates/header.html.inc");
        self::SetHeader("admin-pages/templates/nav.html.inc");
        self::SetFooter("admin-pages/templates/footer.html.inc");
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

    public function Member()
    {
        self::SetBody("admin-pages/member.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Member Management",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/member.css",
                        "public/js/admin/member.js"
                    )
                ) 
            )
        ));  
    }

    public function MemberDetails($member_id)
    {
        self::SetBody("admin-pages/member-details.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Member Details",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => array_merge(
                        $this->GetPageURLs(
                            "public/css/admin/member-details.css",
                            "public/js/admin/member-details.js"
                        ),
                        array(
                            "member_details" => self::GetBaseURL("admin/member")
                        )
                    ),
                    "details" => array(
                        "member_id" => $member_id
                    )
                ) 
            )
        ));  
    }
}
