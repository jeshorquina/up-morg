<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

use \Jesh\Models\BatchModel;

class SystemAdministratorActionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("SystemAdministratorOperations");
    }

    public function CreateBatch()
    {
        $academic_year = Http::Request(Http::POST, "academic_year");

        $validation = $this->operations->CheckAcadYearFormat($academic_year);

        if(!$validation)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, "Wrong format.");
        }
        else 
        {
            $response = $this->operations->CreateBatch(
                new BatchModel(
                    array(
                        "AcadYear" => $academic_year
                    )
                )
            );
            
            if(!$response)
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, "Unable to create new batch.");
            }
            else
            {
                Http::Response(Http::CREATED, "New batch successfully created.");
            }
        }
    }

    public function GetBatches()
    {
        $batches = $this->operations->GetBatches();
        Http::Response(Http::OK, $batches);
    }

    public function GetBatchInformation()
    {

    }

    public function GetMembers()
    {
        
    }    
    public function Login()
    {
        $password = Http::Request(Http::POST, "password");
        if(!$this->operations->MatchingPassword($password))
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, "Password does not match!");
        }
        else 
        {
            Http::Response(Http::OK, "Successfully logged in.");
        }
    }

    public function UpdatePassword()
    {
        $old_password     = Http::Request(Http::POST, "old_password");
        $new_password     = Http::Request(Http::POST, "new_password");
        $confirm_password = Http::Request(Http::POST, "confirm_password");

         $validation = $this->operations->ValidateInput(
            array(
                "old_password" => $old_password,
                "new_password" => $new_password,
                "confirm_password" => $confirm_password,
            )    
        );
        
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else if($new_password !== $confirm_password)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, "New password does not match confirm password!");
        }
        //else if(!$this->operations->MatchingPassword($old_password))
        //{
        //    Http::Response(Http::UNPROCESSABLE_ENTITY, "Entered old password does not match password in record.");
        //}
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, "Password change has not been changed.");
        }
        else 
        {
            Http::Response(Http::OK, "Password has successfully been changed.");
        }
    }
}