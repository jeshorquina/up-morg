<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\BatchModel;
use \Jesh\Models\MemberModel;
use \Jesh\Repository\SystemAdministratorOperationsRepository;

class SystemAdministratorOperations
{
    public function __construct()
    {
        $this->repository = new SystemAdministratorOperationsRepository;
    }

    public function ChangePassword($password)
    {
        return $this->repository->UpdatePassword(Security::GenerateHash($password));
    }

    public function GetBatches()
    {
        return $this->repository->GetBatches();
    }

    public function MatchingPassword($password)
    {
        return Security::CheckPassword($password, $this->repository->GetPassword());
    }

    public function ValidateInput($input_data)
    {

        $validation = new ValidationDataBuilder;

        foreach($input_data as $name => $value) 
        {
            if(strtolower(gettype($value)) === "string") 
            {
                $validation->CheckString($name, $value);
            }
        }
        
        return array(
            "status" => $validation->GetStatus(),
            "data"   => $validation->GetValidationData()
        );
    }

    public function CreateBatch(Batchmodel $batch)
    {
        return $this->repository->InsertBatchToDatabase($batch);

    }

    public function ExistingBatch($value)
    {
        return $this->repository->ExistingBatch($value);
    }

    public function CheckAcadYearFormat($input)
    {
        $regex = "/[0-9]{4}-[0-9]{4}/";
        if(preg_match($regex, $input, $match))
        {
            return true;
        }
        return false;
    }

    public function DeleteBatch($value)
    {
        return $this->repository->DeleteBatch($value);
    }
}