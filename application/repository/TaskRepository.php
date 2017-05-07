<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskCommentModel;
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

    public function GetSubscribedTasks($batch_member_id)
    {
        return self::Get("TaskSubscriber", "*", array(
            "BatchMemberID" => $batch_member_id
        ));
    }

    public function GetParentTask($task_id)
    {
        return self::Get("TaskTree", "*", array("ChildTaskID" => $task_id));
    }

    public function GetChildrenTaskIDs($task_id)
    {
        return self::Get("TaskTree", "*", array("ParentTaskID" => $task_id));
    }

    public function GetTaskCommentsByTaskID($task_id)
    {
        return self::Get("TaskComment", "*", array("TaskID" => $task_id));
    }

    public function GetTaskSubscriber($task_subscriber_id)
    {
        return self::Get("TaskSubscriber", "*", 
            array("TaskSubscriberID" => $task_subscriber_id)
        );
    }

    public function GetTaskSubscriberID($task_id, $batch_member_id)
    {
        return self::Get("TaskSubscriber", "TaskSubscriberID", 
            array("TaskID" => $task_id, "BatchMemberID" => $batch_member_id)
        );
    }

    public function GetTaskSubscribersByTaskID($task_id)
    {
        return self::Get("TaskSubscriber", "*", array("TaskID" => $task_id));
    }

    public function GetTaskStatusID($name)
    {
        return self::Get(
            "TaskStatus", "TaskStatusID", array("Name" => $name)
        );
    }

    public function GetTaskStatus($task_status_id)
    {
        return self::Get(
            "TaskStatus", "*", array("TaskStatusID" => $task_status_id)
        );
    }

    public function HasParentTask($task_id)
    {
        return self::Find(
            "TaskTree", "ParentTaskID", array("ChildTaskID" => $task_id)
        );
    }

    public function IsTaskSubscriber($task_id, $batch_member_id)
    {
        return self::Find(
            "TaskSubscriber", "TaskID", array(
                "TaskID" => $task_id, "BatchMemberID" => $batch_member_id
            )
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

    public function AddComment(TaskCommentModel $comment)
    {
        return self::Insert("TaskComment", $comment);
    }

    public function UpdateTaskStatus($task_id, TaskModel $task)
    {
        return self::Update("Task", array("TaskID" => $task_id), $task);
    }

    public function DeleteTask($task_id)
    {
        return self::Delete("Task", "TaskID", $task_id);
    }
}