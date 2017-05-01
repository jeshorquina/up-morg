<?php
namespace Jesh\Operations\Repository;

use \Jesh\Helpers\StringHelper;

use \Jesh\Repository\TaskRepository;

class Task
{
    private $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository;
    }
}
