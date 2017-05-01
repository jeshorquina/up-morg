<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Models\TaskModel;
use \Jesh\Models\TaskSubscriberModel;

use \Jesh\Repository\TaskRepository;

class Task
{
    const TODO = "To Do";

    private $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository;
    }

    public function GetTaskStatusID($name)
    {
        return $this->repository->GetTaskStatusID($name)[0]["TaskStatusID"];
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

}
