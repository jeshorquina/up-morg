<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\UserSession;

class AvailabilityPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->SetTemplates();
    }

    private function SetTemplates()
    {
        self::SetHeader("admin/templates/header.html.inc");
        self::SetHeader("admin/templates/nav.html.inc");
        self::SetFooter("admin/templates/footer.html.inc");
    }

    public function AvailabilityIndex()
    {
        if(PageRenderer::HasAvailavilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker"
                    )
                ),
            );

            if(UserSession::IsFrontman())
            {
                self::SetBody("user/availability/modify-frontman.html.inc");
            }
            else
            {
                self::SetBody("user/availability/modify-committee.html.inc");
            }

            self::RenderView(
                PageRenderer::GetUserPageData("availability-modify", $other_details)
            );
        }
    }
}