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
        self::SetHeader("templates/header.html.inc");
        self::SetHeader("templates/nav.html.inc");
        self::SetFooter("templates/footer.html.inc");
    }

    public function ModifyAvailability()
    {
        if(PageRenderer::HasModifyAvailavilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker"
                    ),
                ),
            );

            self::SetBody("user/availability/modify.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-modify", $other_details
                )
            );
        }
    }

    public function CommitteeAvailability()
    {
        if(PageRenderer::HasCommitteeAvailabilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker"
                    ),
                ),
            );

            self::SetBody("user/availability/committee.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-committee", $other_details
                )
            );
        }
    }

    public function GroupAvailability()
    {
        if(PageRenderer::HasGroupAvailabilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker"
                    ),
                ),
            );

            self::SetBody("user/availability/group.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-group", $other_details
                )
            );
        }
    }

    public function MemberAvailability()
    {
        if(PageRenderer::HasMemberAvailabilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker"
                    ),
                ),
            );

            self::SetBody("user/availability/member.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-member", $other_details
                )
            );
        }
    }
}