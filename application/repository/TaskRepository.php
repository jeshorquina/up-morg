<?php
namespace Jesh\Repository;

use \Jesh\Core\Wrappers\Repository;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;

class TaskRepository extends Repository
{
    public function GetTaskStatusID($name)
    {
        return self::Get(
            "TaskStatus", "TaskStatusID", array("Name" => $name)
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
}