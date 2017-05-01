<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;
use \Jesh\Models\TaskTreeModel;

class TaskRepository extends Repository
{
    public function GetTask($task_id)
    {
        return self::Get("Task", "*", array("TaskID" => $task_id));
    }

    public function GetAssignedTasks($batch_member_id)
    {
        return self::Get(
            "Task", "*", array("Assignee" => $batch_member_id)
        );
    }

    public function GetReportedTasks($batch_member_id)
    {
        return self::Get(
            "Task", "*", array("Reporter" => $batch_member_id)
        );
    }

    public function GetTaskStatusID($name)
    {
        return self::Get(
            "TaskStatus", "TaskStatusID", array("Name" => $name)
        );
    }

    public function HasParentTask($task_id)
    {
        return self::Find(
            "TaskTree", "ParentTaskID", array("ChildTaskID" => $task_id)
        );
    }

    public function AddTask(TaskModel $task)
    {
        return self::Insert("Task", $task);
    }

    public function AddSubscriber(TaskSubscriberModel $subscriber)
    {
        return self::Insert("TaskSubscriber", $subscriber);
    }

    public function AddParentTask(TaskTreeModel $relation)
    {
        return self::Insert("TaskTree", $relation);
    }
}