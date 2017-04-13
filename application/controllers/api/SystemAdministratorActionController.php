<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\StringHelper;

use \Jesh\Models\BatchModel;
use \Jesh\Models\BatchMemberModel;

class SystemAdministratorActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations(
            "SystemAdministratorActionOperations"
        );
    }

    public function Login()
    {
        $password = Http::Request(Http::POST, "password");
        
        if(!$this->operations->MatchingPassword($password))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Password does not match!"
                )
            );
        }
        else 
        {
            $this->operations->SetLoggedInState();
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully logged in.",
                    "redirect_url" => self::GetBaseURL('admin')
                )
            );
        }
    }

    public function Logout()
    {
        if(!$this->operations->SetLoggedOutState())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Could not log out. Please try again."
                )
            );
        }
        else
        {
            Http::Response(
                HTTP::FOUND, array(
                    "message" => "Successfully logged out."
                ),
                "Location: " . self::GetBaseURL('admin')
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
                Http::UNPROCESSABLE_ENTITY, array(
                    "new-password" => "Passwords does not match!",
                    "confirm-password" => "Passwords does not match!"
                )
            );
        }
        else if(!$this->operations->MatchingPassword($old_password))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "old-password" => "Invalid old password provided."
                )
            );
        }
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Something went wrong. Password not changed."
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Password has successfully been changed.",
                    "redirect_url" => self::GetBaseURL("action/admin/logout")
                )
            );
        }
    }

    public function GetBatches()
    {
        if(!$batches = $this->operations->GetBatches()) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get batches. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Batches successfully retrieved.",
                    "data" => $batches
                )
            );
        }
    } 

    public function AddBatch()
    {
        $academic_year = Http::Request(Http::POST, "academic-year");

        if(!$this->operations->CheckAcadYearFormat($academic_year))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Batch input is of wrong format."
                )
            );
        }
        else if($this->operations->ExistingBatchByYear($academic_year))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Batch already exists"
                )
            );
        }
        else if(!$response = $this->operations->CreateBatch(
            new BatchModel(
                array("AcadYear" => $academic_year)
            )
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to create new batch."
                )
            );
        }
        elseif(!$batches = $this->operations->GetBatches())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get batches. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => "Successfully added batch.",
                    "data" => $batches
                )
            );
        }
    }

    public function ActivateBatch()
    {
        $batch_id = Http::Request(Http::POST, "batch-id");

        if(!$this->operations->HasFirstFrontman($batch_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Please select first frontman before activating batch."
                    )
                )
            );
        }
        else if(!$this->operations->ActivateBatch($batch_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to activate batch. PLease try again."
                )
            );
        }
        else if(!$batches = $this->operations->GetBatches())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get batches. Please try again."
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully activated batch.",
                    "data" => $batches
                )
            );
        }
    }
    
    public function DeleteBatch()
    {
        $batch_id = Http::Request(Http::POST, "batch-id");

        if(!$this->operations->ExistingBatchByID($batch_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Batch selected is not present in database."
                )
            );
        }
        else if($this->operations->IsActiveBatch($batch_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Could not delete batch. Batch selected is 
                    the current active batch."
                )
            );
        }
        else if(!$this->operations->DeleteBatch($batch_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to delete selected batch. Make sure batch 
                        doesn't have any members."
                    )
                )
            );
        }
        elseif(!$batches = $this->operations->GetBatches())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get batches. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully deleted batch.",
                    "data" => $batches
                )
            );
        }
    }

    public function GetBatchDetails($batch_id) 
    {
        if(!$batch_details = $this->operations->GetBatchDetails($batch_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare batch details. Please refresh
                        browser."
                    )
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Batch details successfully processed.",
                    "data" => $batch_details
                )
            );
        }
        
    }

    public function GetAllMembers()
    {
        if(!$members = $this->operations->GetAllMembers()) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get members. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Members successfully retrieved.",
                    "data" => $members
                )
            );
        }
    }

    public function AddBatchMember($batch_id)
    {
        $member_id = Http::Request(Http::POST, "member-id");

        if($this->operations->MemberInBatch($batch_id, $member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is already in batch."
                    )
                )
            );
        }
        else if(!$this->operations->AddMemberToBatch(
            new BatchMemberModel(
                array(
                    "BatchID" => $batch_id,
                    "MemberID" => $member_id
                )
            )
        )) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not add member to batch. Please try again."
                    )
                )
            );
        }
        else if(!$batch_details = $this->operations->GetBatchDetails($batch_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare batch details. Please refresh
                        browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => "Member successfully added to batch.",
                    "data" => $batch_details
                )
            );
        }
    }

    public function RemoveMemberFromBatch($batch_id)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(!$this->operations->BatchMemberInBatch($batch_member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is not in batch. Nothing to remove."
                    )
                )
            );
        }
        else if(!$this->operations->RemoveMemberFromBatch($batch_member_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not remove member from batch. Please try again."
                    )
                )
            );
        }
        else if(!$batch_details = $this->operations->GetBatchDetails($batch_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare batch details. Please refresh
                        browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => "Member successfully removed from batch.",
                    "data" => $batch_details
                )
            );
        }
    }
}