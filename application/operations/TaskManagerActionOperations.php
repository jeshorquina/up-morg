<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Repository\TaskManagerActionOperationsRepository;

use \Jesh\Models\TaskModel;

class TaskManagerActionOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new TaskManagerActionOperationsRepository;
    }

    public function GetMemberID($username)
    {
        return $this->repository->GetMemberID($username);
    }

    public function GetTaskStatus($status_id)
    {
        return $this->repository->GetTaskStatus($status_id);
    }

    public function AddTask(Taskmodel $task)
    {
        return $this->repository->AddTask($task);
    }

    public function GetCurrentUserTasks($user_id)
    {
        $tasks = array();

        foreach($this->repository->GetCurrentUserTasks($user_id, "DESC") as $task)
        {
            $new_task["title"] = $task["TaskTitle"];
            $new_task["deadline"] = $task["TaskDeadline"];
            $new_task["reporter"] = $this->GetTaskReporter($task["Reporter"]);
            $new_task["status"] = $this->GetTaskStatus($task["TaskStatusID"]);
            
            $tasks[] = $new_task;
        }

        return (sizeof($tasks) != 0) ? $tasks : false;
    }

    public function GetReportedTasks($user_id)
    {
        $tasks = array();

        foreach($this->repository->GetReportedTasks($user_id, "DESC") as $task)
        {
            $new_task["title"] = $task["TaskTitle"];
            $new_task["deadline"] = $task["TaskDeadline"];
            $new_task["assignee"] = $this->GetTaskReporter($task["Assignee"]);
            $new_task["status"] = $this->GetTaskStatus($task["TaskStatusID"]);
            
            $tasks[] = $new_task;
        }

        return (sizeof($tasks) != 0) ? $tasks : false;
    }

    public function GetTaskReporter($reporter)
    {
        return $this->repository->GetTaskReporter($reporter);
    }

    public function GetTaskAssignee($assignee)
    {
        return $this->repository->GetTaskAssignee($assignee);
    }

    public function ValidateTaskData($title, $description, $assignee, $month, $day, $year)
    {
        $validation = new ValidationDataBuilder;

        $validation->CheckString("title", $title);
        $validation->CheckString("description", $description);
        //$validation->CheckString("assignee", $assignee);
        $validation->CheckString("month", $month);
        $validation->CheckString("day", $day);
        $validation->CheckString("year", $year);
                
        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function SubmitTask()
    {
        
    }
}
