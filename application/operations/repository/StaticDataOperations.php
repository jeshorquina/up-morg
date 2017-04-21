<?php
namespace Jesh\Operations\Repository;

use \Jesh\Repository\StaticDataOperationsRepository;

class StaticDataOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new StaticDataOperationsRepository;
    }

    public function GetAdminPassword()
    {
        $password = $this->repository->GetAdminPassword();
        if(sizeof($password) === 1)
        {
            return $password[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for system admin password found");
        }
    }

    public function ChangePassword($password)
    {
        return $this->repository->ChangePassword($password);
    }
}
