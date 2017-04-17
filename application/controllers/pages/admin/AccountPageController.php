<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

class AccountPageController extends Controller
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

    public function ChangePassword()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Admin - Change Password"
                )
            )
        );

        self::SetBody("admin/password.html.inc");
        self::RenderView(
            PageRenderer::GetAdminPageData(
                Url::GetBaseURL(), "password", $other_details
            )
        );
    }
}
