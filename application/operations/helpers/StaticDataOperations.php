<?php
namespace Jesh\Operations\Helpers;

use \Jesh\Repository\StaticDataOperationsRepository;

class StaticDataOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new StaticDataOperationsRepository;
    }

    public function GetPassword()
    {
        return $this->repository->GetPassword();
    }

    public function ChangePassword($password)
    {
        return $this->repository->ChangePassword($password);
    }
}
