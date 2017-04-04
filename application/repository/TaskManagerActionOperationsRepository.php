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
}