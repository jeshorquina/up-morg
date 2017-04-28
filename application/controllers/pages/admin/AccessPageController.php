<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

class AccessPageController extends Controller
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
        self::SetHeader("templates/header.html.inc");
        self::SetHeader("templates/nav.html.inc");
        self::SetFooter("templates/footer.html.inc");
    }

    public function Home()
    {
        Url::Redirect("admin/batch");
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
            PageRenderer::GetAdminPageData("login", $other_details, false)
        );
    }
}
