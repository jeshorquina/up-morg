<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\StringHelper;

class BatchPageController extends Controller
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

    public function Batch()
    {
        self::SetBody("admin-pages/batch.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Batch Management",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch.css",
                        "public/js/admin/batch.js"
                    )
                ) 
            )
        ));  
    }

    public function BatchDetails($batch_id)
    {
        self::SetBody("admin-pages/batch-details.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Batch Details",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => $this->GetPageURLs(
                        "public/css/admin/batch-details.css",
                        "public/js/admin/batch-details.js"
                    ),
                    "details" => array(
                        "batch_id" => $batch_id
                    )
                ) 
            )
        ));  
    }

    public function BatchCommitteeDetails($batch_id, $committee_name)
    {
        if($committee_name == "frontman") 
        {
            self::SetBody("admin-pages/batch-details-frontman.html.inc");
        }
        else 
        {
            self::SetBody("admin-pages/batch-details-committee.html.inc");    
        }

        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Batch Committee Details",
                    "nav" => $this->GetNavigationLinks(),
                    "urls" => array_merge($this->GetPageURLs(
                        "public/css/admin/batch-details-committee.css",
                        "public/js/admin/batch-details-committee.js"
                    ), array(
                        "batch_list" => self::GetBaseURL('admin/batch'),
                        "batch_details" => self::GetBaseURL(
                            'admin/batch/details/'.$batch_id
                        )
                    )),
                    "details" => array(
                        "batch_id" => $batch_id,
                        "committee_name" => StringHelper::UnmakeIndex(
                            $committee_name
                        )
                    )
                ) 
            )
        ));
    }
}
