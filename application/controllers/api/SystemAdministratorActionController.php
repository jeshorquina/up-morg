<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;

use \Jesh\Models\BatchModel;

class SystemAdministratorActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("SystemAdministratorOperations");
    }

    public function Login()
    {
        $password = Http::Request(Http::POST, "password");
        
        if(!$this->operations->MatchingPassword($password))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "Password does not match!"
            );
        }
        else 
        {
            $this->operations->SetLoggedInState();
            Http::Response(Http::OK, 
                "Successfully logged in."
            );
        }
    }

    public function Logout()
    {
        if($this->operations->SetLoggedOutState())
        {
            Http::Response(HTTP::OK, "Successfully logged out.");
        }
        else
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, "Something went wrong.");
        }
    }

    public function CreateBatch()
    {
        $academic_year = Http::Request(Http::POST, "academic_year");

        if(!$this->operations->CheckAcadYearFormat($academic_year))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "Batch input is of wrong format."
            );
        }
        else if($this->operations->ExistingBatchByYear($academic_year))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "Batch already exists"
            );
        }
        else{
            $response = $this->operations->CreateBatch(
                new BatchModel(
                    array("AcadYear" => $academic_year)
                )
            );
            if(!$response) 
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, 
                    "Unable to create new batch."
                );
            }
            else 
            {
                Http::Response(Http::CREATED, 
                    "New batch successfully created."
                );
            }
        }
    }

    public function GetBatches()
    {
        Http::Response(Http::OK, $this->operations->GetBatches());
    } 

    public function DeleteBatch()
    {
        $batch_id = Http::Request(Http::POST, "batch_id");

        if(!$this->operations->ExistingBatchByID($batch_id)) 
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "Batch selected is no longer present in database."
            );
        }
        else if(!$this->operations->DeleteBatch($batch_id))
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, 
                "Unable to delete selected batch."
            );
        }
        else
        {
            Http::Response(Http::OK, 
                "Successfully deleted batch."
            );
        }
    }

    public function UpdatePassword()
    {
        $old_password     = Http::Request(Http::POST, "old_password");
        $new_password     = Http::Request(Http::POST, "new_password");
        $confirm_password = Http::Request(Http::POST, "confirm_password");

         $validation = $this->operations->ValidateUpdatePasswordData(
            array(
                "old_password" => $old_password,
                "new_password" => $new_password,
                "confirm_password" => $confirm_password,
            )    
        );
        
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                $validation["data"]
            );
        }
        else if($new_password !== $confirm_password)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "New password does not match confirm password!"
            );
        }
        else if(!$this->operations->MatchingPassword($old_password))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                "Old password does not match password in record."
            );
        }
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, 
                "Password has not been changed."
            );
        }
        else 
        {
            Http::Response(Http::OK, 
                "Password has successfully been changed."
            );
        }
    }
}