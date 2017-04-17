<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class AccessPageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasAdminPageAccess(self::GetBaseURL(), self::GetURI()))
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

    public function Home()
    {
        self::Redirect("admin/batch");
    }

    public function Login()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Login Page"
                )
            )
        );

        self::SetBody("admin/login.html.inc");
        self::RenderView(
            PageRenderer::GetAdminPageData(
                self::GetBaseURL(), "login", $other_details, false
            )
        );
    }
}
