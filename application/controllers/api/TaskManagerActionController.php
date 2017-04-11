<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

use \Jesh\Models\TaskModel;

class TaskManagerActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("TaskManagerActionOperations");
    }

    public function AddTask()
    {
        $task_title = Http::Request(Http::POST, "task_title");
        $task_description = Http::Request(Http::POST, "task_description");
        $task_assignee = Http::Request(Http::POST, "task_assignee");
        $task_deadline_month = Http::Request(Http::POST, "task_deadline_month");
        $task_deadline_day = Http::Request(Http::POST, "task_deadline_day");
        $task_deadline_year = Http::Request(Http::POST, "task_deadline_year");
        $task_subscribers = Http::Request(Http::POST, "task_subscribers");

        $validation = $this->operations->ValidateTaskData($task_title, $task_description, $task_assignee,
                                                          $task_deadline_month, $task_deadline_day, $task_deadline_year);
        
        $user_data = json_decode(Session::Get("user_data"), true);
        $user_id = $user_data["id"];
        

        if($validation["status"] === true)
        {
            if(checkdate($task_deadline_month, $task_deadline_day, $task_deadline_year))
            {
                $task_deadline = $task_deadline_year . "-" . $task_deadline_month . "-" . $task_deadline_day;
                
                $get_status = $this->operations->GetTaskStatus(0);
                $status = $get_status[0]["TaskStatusID"];

                $response = $this->operations->AddTask(
                    new TaskModel(
                        array(
                            "TaskStatusID" => (int) $status,
                            "Reporter" => (int) $user_id,
                            "Assignee" => (int) $task_assignee,
                            "TaskTitle" => $task_title,
                            "TaskDescription" => $task_description,
                            "TaskDeadline" => $task_deadline
                        )
                    )
                );

                if(!$response) 
                {
                    Http::Response(Http::INTERNAL_SERVER_ERROR, 
                        "Unable to add task."
                    );
                }
                else 
                {
                    Http::Response(Http::CREATED, 
                        "Task successfully added."
                    );
                }
            }
            else 
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, 
                        "Invalid date. Unable to add task."
                    );
            } 
        }
        else
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }

    }

    public function AcceptTask()
    {

    }

    public function DeclineTask()
    {
        
    }

    public function SubmitTask()
    {

    }

}
