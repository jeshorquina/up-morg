<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Url;
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

    public function AvailabilityIndex()
    {
        Url::Redirect("availability/manage");
    }

    public function ModifyAvailability()
    {
        if(PageRenderer::HasModifyAvailabilityPageAccess())
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

    public function GroupAvailabilityViewPage($group_id)
    {
        if(PageRenderer::HasGroupAvailabilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker",
                        "urls" => array(
                            "group_page" => (
                                Url::GetBaseURL("availability/group")
                            )
                        ),
                        "details" => array(
                            "group_id" => $group_id
                        )
                    ),
                ),
            );

            self::SetBody("user/availability/group/view.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-group-view", $other_details
                )
            );
        }
    }

    public function GroupAvailabilityEditPage($group_id)
    {
        if(PageRenderer::HasGroupAvailabilityPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Availability Tracker",
                        "urls" => array(
                            "group_page" => (
                                Url::GetBaseURL("availability/group")
                            )
                        ),
                        "details" => array(
                            "group_id" => $group_id
                        )
                    ),
                ),
            );

            self::SetBody("user/availability/group/edit.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "availability-group-edit", $other_details
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