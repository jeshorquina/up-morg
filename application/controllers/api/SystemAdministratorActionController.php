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

        $this->operations = self::InitializeOperations("SystemAdministratorActionOperations");
    }

    public function Login()
    {
        $password = Http::Request(Http::POST, "password");
        
        if(!$this->operations->MatchingPassword($password))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, 
                array(
                    "message" => "Password does not match!"
                )
            );
        }
        else 
        {
            $this->operations->SetLoggedInState();
            Http::Response(Http::OK, 
                array(
                    "message" => "Successfully logged in.",
                    "redirect_url" => self::GetBaseURL('admin')
                )
            );
        }
    }

    public function Logout()
    {
        if($this->operations->SetLoggedOutState())
        {
            Http::Response(
                HTTP::FOUND,
                "Successfully logged out.",
                "Location: " . self::GetBaseURL('admin')
            );
        }
        else
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, 
                "Something went wrong."
            );
        }
    }

    public function GetBatches()
    {
        $batches = $this->operations->GetBatches();
        if($batches) 
        {
            Http::Response(Http::OK, $batches);
        }
        else 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, 
                array(
                    "message" => "Something went wrong. 
                    Please refresh your browser."
                )    
            );
        }
    } 

    public function AddBatch()
    {
        $academic_year = Http::Request(Http::POST, "academic-year");

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

    public function DeleteBatch()
    {
        $batch_id = Http::Request(Http::POST, "batch-id");

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

    public function ChangePassword()
    {
        $old_password     = Http::Request(Http::POST, "old-password");
        $new_password     = Http::Request(Http::POST, "new-password");
        $confirm_password = Http::Request(Http::POST, "confirm-password");

         $validation = $this->operations->ValidateUpdatePasswordData(
            array(
                "old-password" => $old_password,
                "new-password" => $new_password,
                "confirm-password" => $confirm_password,
            )    
        );
        
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else if($new_password !== $confirm_password)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array(
                    "new-password" => "Passwords does not match!",
                    "confirm-password" => "Passwords does not match!"
                )
            );
        }
        else if(!$this->operations->MatchingPassword($old_password))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array(
                    "old-password" => "Invalid old password provided."
                )
            );
        }
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, 
                array(
                    "message" => "Something went wrong. Password not changed."
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, 
                array(
                    "message" => "Password has successfully been changed.",
                    "redirect_url" => self::GetBaseURL("action/admin/logout")
                )
            );
        }
    }
}