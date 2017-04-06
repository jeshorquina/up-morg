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

    public function GetTaskStatus($value)
    {
        return self::Get("TaskStatus", "TaskStatusID", array("TaskStatusID" => $value));
    }
}