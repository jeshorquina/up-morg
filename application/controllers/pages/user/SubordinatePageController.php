<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\UserSession;

class SubordinatePageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess("subordinate")) 
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

    public function SubordinateIndex()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Member Manager"
                )
            ),
        );

        $page_name = "";
        if(UserSession::IsFirstFrontman())
        {
            self::SetBody("user/subordinate/first-frontman.html.inc");
            $page_name = "first-frontman-subordinate";
        }
        else if(UserSession::IsFrontman())
        {
            self::SetBody("user/subordinate/frontman.html.inc");
            $page_name = "frontman-subordinate";
        }
        else
        {
            self::SetBody("user/subordinate/committee-head.html.inc");
            $page_name = "committee-head-subordinate";
        }

        self::RenderView(
            PageRenderer::GetUserPageData($page_name, $other_details)
        );
    }
}