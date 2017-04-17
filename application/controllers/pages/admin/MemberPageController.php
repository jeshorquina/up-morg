<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Url;

class MemberPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasAdminPageAccess()) 
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

    public function Member()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Member Management"
                )
            )
        );

        self::SetBody("admin/member.html.inc");
        self::RenderView(
            PageRenderer::GetAdminPageData(
                Url::GetBaseURL(), "member", $other_details
            )
        );
    }

    public function MemberDetails($member_id)
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Member Details",
                    "urls" => array(
                        "member_details" => Url::GetBaseURL("admin/member")
                    ),
                    "details" => array(
                        "member_id" => $member_id
                    )
                )
            )
        );

        self::SetBody("admin/member/details.html.inc");
        self::RenderView(
            PageRenderer::GetAdminPageData(
                Url::GetBaseURL(), "member-details", $other_details
            )
        );
    }
}
