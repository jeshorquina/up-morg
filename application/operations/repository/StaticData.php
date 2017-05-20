<?php
namespace Jesh\Operations\Repository;

use \Jesh\Repository\StaticDataRepository;

class StaticData
{
    private $repository;

    public function __construct()
    {
        $this->repository = new StaticDataRepository;
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

    public function GetAcadYearStartMonth()
    {
        $month = $this->repository->GetAcadYearStartMonth();
        if(sizeof($month) === 1)
        {
            return $month[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for acad year start month found");
        }
    }

    public function GetAcadYearEndMonth()
    {
        $month = $this->repository->GetAcadYearEndMonth();
        if(sizeof($month) === 1)
        {
            return $month[0]["Value"];
        }
        else 
        {
            throw new \Exception("No record for acad year end month found");
        }
    }
}
