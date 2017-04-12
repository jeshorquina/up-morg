<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\TaskModel;

class TaskManagerActionOperationsRepository extends Repository
{
    public function AddTask(Taskmodel $task)
    {
        return self::Insert("Task", $task);
    }

    public function GetMemberID($username)
    {
        return self::Get("Member", "MemberID", array("EmailAddress" => $username));
    }

    public function GetTaskStatus($status_id)
    {
        return self::Get("TaskStatus", "Name", array("TaskStatusID" => $status_id))[0]["Name"];
    }

    public function GetTaskReporter($reporter)
    {
        $first_name = self::Get("Member", "FirstName", array("MemberID" => $reporter))[0]["FirstName"];
        $last_name = self::Get("Member", "LastName", array("MemberID" => $reporter))[0]["LastName"];
        return $first_name . " " . $last_name;
    }

    public function GetTaskAssignee($assignee)
    {
        $first_name = self::Get("Member", "FirstName", array("MemberID" => $assignee))[0]["FirstName"];
        $last_name = self::Get("Member", "LastName", array("MemberID" => $assignee))[0]["LastName"];
        return $first_name . " " . $last_name;
    }

    public function GetCurrentUserTasks($user_id, $order)
    {
        return self::Get("Task", "*", array("Assignee" => $user_id), array("TaskTitle" => $order));
    }

    public function GetReportedTasks($user_id, $order)
    {
        return self::Get("Task", "*", array("Reporter" => $user_id), array("TaskTitle" => $order));
    }
    
}