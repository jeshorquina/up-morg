<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;
use \Jesh\Models\TaskTreeModel;

use \Jesh\Repository\TaskRepository;

class Task
{
    const TODO = "To Do";

    private $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository;
    }

    public function GetTask($task_id)
    {
        $task = $this->repository->GetTask($task_id);

        if(!$task)
        {
            throw new \Exception("Cound not find task in the database");
        }

        return new TaskModel($task[0]);
    }

    public function GetAssignedTasks($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetAssignedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($task);
        }
        return $tasks;
    }

    public function GetReportedTasks($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetReportedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($task);
        }
        return $tasks;
    }

    public function GetSubscribedTaskIDs($batch_member_id)
    {
        $tasks = array();
        foreach($this->repository->GetSubscribedTasks($batch_member_id) as $task)
        {
            $tasks[] = new TaskModel($this->GetTask($task["TaskID"]));
        }
        return $tasks;
    }

    public function GetParentTaskID($task_id)
    {
        $task = $this->repository->GetParentTask($task_id);

        if(!$task)
        {
            throw new \Exception("Cound not find parent task in the database");
        }

        return $task[0]["ParentTaskID"];
    }

    public function GetTaskStatusID($name)
    {
        $is_found = $this->repository->GetTaskStatusID($name);
    
        if(!$is_found)
        {
            throw new \Exception(
                sprintf(
                    "Cound not find task status `%s` in the database.",$name
                )
            );
        }

        return $is_found[0]["TaskStatusID"];
    }

    public function HasParentTask($task_id)
    {
        return $this->repository->HasParentTask($task_id);
    }

    public function IsTaskSubscriber($task_id, $batch_member_id)
    {
        return $this->repository->IsTaskSubscriber($task_id, $batch_member_id);
    }

    public function AddTask(TaskModel $task)
    {
        $is_added = $this->repository->AddTask($task);

        if(!$is_added)
        {
            throw new \Exception("Cound not add task to the database.");
        }

        return $is_added;
    }

    public function AddSubscriber(TaskSubscriberModel $subscriber)
    {
        $is_added = $this->repository->AddSubscriber($subscriber);

        if(!$is_added)
        {
            throw new \Exception(
                "Cound not add task subscriber to the database."
            );
        }

        return $is_added;
    }

    public function AddParentTask(TaskTreeModel $relation)
    {
        $is_added = $this->repository->AddParentTask($relation);

        if(!$is_added)
        {
            throw new \Exception(
                "Cound not add task relationship to the database."
            );
        }

        return $is_added;
    }
}
