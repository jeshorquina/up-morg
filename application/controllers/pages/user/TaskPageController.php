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

    public function ViewTaskListPage()
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

    public function ViewTaskDetailsPage($task_id)
    {
        if(PageRenderer::HasTaskDetailsPageAccess($task_id)) 
        {
            $other_details = array(
            Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Task Manager",
                        "urls" => array(
                            "task_page" => Url::GetBaseURL("task/view")
                        ),
                        "details" => array(
                            "task_id" => $task_id
                        )
                    )
                ),
            );

            self::SetBody("user/task/details/view.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "task-details-view", $other_details
                )
            );
        }
    }

    public function EditTaskPage($task_id)
    {
        if(PageRenderer::HasEditTaskPageAccess($task_id))
        {
            $other_details = array(
            Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Task Manager",
                        "urls" => array(
                            "task_page" => Url::GetBaseURL("task/view")
                        ),
                        "details" => array(
                            "task_id" => $task_id
                        )
                    )
                ),
            );

            self::SetBody("user/task/details/edit.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "task-details-edit", $other_details
                )
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