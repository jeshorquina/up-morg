<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

class RequestPageController extends Controller 
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

    public function RequestIndex($type)
    {
        if($type !== "batch" && $type !== "committee")
        {
            Url::PageNotFound();
        }
        else if(PageRenderer::HasUserPageAccess(sprintf("request-%s", $type))) 
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
                    sprintf("request-%s", $type), $other_details
                )
            );   
        }
    }
}