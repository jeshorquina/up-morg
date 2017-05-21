<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\UserSession;

class UserAccountPageController extends Controller 
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

    public function AccountIndex()
    {
        Url::Redirect("account/password");
    }

    public function AccounPasswordPage()
    {
        if(PageRenderer::HasAccountPasswordPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Account"
                    ),
                ),
            );

            self::SetBody("user/account/password.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "account-password", $other_details
                )
            );
        }
    }
}