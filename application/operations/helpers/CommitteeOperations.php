<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Repository\Helpers\CommitteeOperationsRepository;

class CommitteeOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new CommitteeOperationsRepository;
    }

    public function GetCommittees()
    {
        return $this->repository->GetCommittees();
    }
}
