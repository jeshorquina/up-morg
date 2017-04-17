<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class FinancePageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess(self::GetBaseURL(), "finance")) 
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

    public function FinanceIndex()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Finance Tracker"
                )
            ),
        );

        self::SetBody("user/finance.html.inc");
        self::RenderView(
            PageRenderer::GetUserPageData(
                self::GetBaseURL(), "finance", $other_details
            )
        );   
    }
}