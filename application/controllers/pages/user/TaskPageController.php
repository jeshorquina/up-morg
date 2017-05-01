<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Url;

class TaskPageController extends Controller 
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

    public function TaskIndex()
    {
        Url::Redirect("task/view");
    }

    public function ViewOpenTasksPage()
    {
        if(PageRenderer::HasTaskPageAccess()) 
        {
            $other_details = array(
            Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Task Manager"
                    )
                ),
            );

            self::SetBody("user/task/view.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("task-view", $other_details)
            );
        }
    }

    public function AddTasksPage()
    {
        if(PageRenderer::HasAddTaskPageAccess()) 
        {
            $other_details = array(
            Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Task Manager"
                    )
                ),
            );

            self::SetBody("user/task/add.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("task-add", $other_details)
            );
        }
    }
}