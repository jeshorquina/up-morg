<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class SubordinatePageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess(self::GetBaseURL(), "subordinate")) 
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

        self::SetBody("user/subordinate.html.inc");
        self::RenderView(
            PageRenderer::GetUserPageData(
                self::GetBaseURL(), "subordinate", $other_details
            )
        );   
    }
}