<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class TaskPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess("task")) 
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

    public function TaskIndex()
    {
        $other_details = array(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Task Manager",
                    "session" => Session::Get("user_data")
                )
            ),
        );

        self::SetBody("user/task.html.inc");
        self::RenderView(
            PageRenderer::GetUserPageData("task", $other_details)
        );   
    }
}