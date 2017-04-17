<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

class CalendarPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess("calendar"))
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

    public function CalendarIndex()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Calendar"
                )
            ),
        );

        self::SetBody("user/calendar.html.inc");
        self::RenderView(
            PageRenderer::GetUserPageData(
                Url::GetBaseURL(), "calendar", $other_details
            )
        );   
    }
}