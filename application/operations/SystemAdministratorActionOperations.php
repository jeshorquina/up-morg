<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\BatchModel;
use \Jesh\Models\MemberModel;
use \Jesh\Repository\SystemAdministratorActionOperationsRepository;

class SystemAdministratorActionOperations
{
    public function __construct()
    {
        $this->repository = new SystemAdministratorActionOperationsRepository;
    }

    public function SetLoggedInState()
    {
        return Session::Set("admin_data", "TRUE");
    }

    public function SetLoggedOutState()
    {
        return Session::End();
    }

    public function GetBatches()
    {
        return $this->repository->GetBatches("DESC");
    }

    public function CheckAcadYearFormat($input)
    {
        return filter_var(
            preg_match("/[0-9]{4}-[0-9]{4}/", $input), 
            FILTER_VALIDATE_BOOLEAN
        );
    }

    public function ExistingBatchByID($batch_id)
    {
        return $this->repository->ExistingBatchByID($batch_id);
    }

    public function ExistingBatchByYear($acad_year)
    {
        return $this->repository->ExistingBatchByYear($acad_year);
    }

    public function CreateBatch(Batchmodel $batch)
    {
        return $this->repository->InsertBatchToDatabase($batch);
    }

    public function DeleteBatch($batch_id)
    {
        return $this->repository->DeleteBatchByID($batch_id);
    }

    public function ValidateUpdatePasswordData($input_data)
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

    public function MatchingPassword($password)
    {
        return Security::CheckPassword($password, $this->repository->GetPassword());
    }

    public function ChangePassword($password)
    {
        return $this->repository->UpdatePassword(Security::GenerateHash($password));
    }

}