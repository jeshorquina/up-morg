<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class RequestPageController extends Controller 
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

    public function RequestIndex($type)
    {
        if($type !== "batch" && $type !== "committee")
        {
            self::PageNotFound();
        }
        else if(PageRenderer::HasUserPageAccess(
            self::GetBaseURL(), sprintf("request-%s", $type)
        )) 
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Request ".ucwords($type)
                    )
                ),
            );

            self::SetBody(sprintf("user/request/%s.html.inc", $type));
            self::RenderView(
                PageRenderer::GetUserPageData(
                    self::GetBaseURL(), 
                    sprintf("request-%s", $type), 
                    $other_details
                )
            );   
        }
    }
}