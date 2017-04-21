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

        $this->SetTemplates();
    }

    private function SetTemplates()
    {
        self::SetHeader("admin/templates/header.html.inc");
        self::SetHeader("admin/templates/nav.html.inc");
        self::SetFooter("admin/templates/footer.html.inc");
    }

    public function FinanceIndex()
    {
        if(PageRenderer::HasFinancePageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Finance Tracker"
                    )
                ),
            );

            self::SetBody("user/finance/finance.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("finance", $other_details)
            );
        }
    }

    public function FinanceActivation()
    {
        if(PageRenderer::HasFinanceActivationPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Finance Tracker"
                    )
                ),
            );

            self::SetBody("user/finance/activation.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "finance-activation", $other_details
                )
            );
        }
    }
}