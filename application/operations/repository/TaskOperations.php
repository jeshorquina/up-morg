<?php
namespace Jesh\Operations\Repository;

use \Jesh\Repository\TaskOperationsRepository;

class TaskOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new TaskOperationsRepository;
    }
}
