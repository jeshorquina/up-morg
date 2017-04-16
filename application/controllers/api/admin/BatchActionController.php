<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\StringHelper;

use \Jesh\Operations\Admin\BatchActionOperations;

class BatchActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new BatchActionOperations;
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
        else if(!$response = $this->operations->CreateBatch($academic_year))
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

        if(!$this->operations->HasFrontmen($batch_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Please select all frontmen before activating batch."
                    )
                )
            );
        }
        else if(!$this->operations->HasCommitteeHeads($batch_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Please assign committee heads to all committees 
                        before activating batch."
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
        else if(!$this->operations->AddMemberToBatch($batch_id, $member_id)) 
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
                Http::OK, array(
                    "message" => "Member successfully removed from batch.",
                    "data" => $batch_details
                )
            );
        }
    }

    public function GetBatchCommitteeDetails($batch_id, $committee_name)
    {
        if(!$this->operations->HasCommitteeName($committee_name)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare batch committee details using the
                        given committee name."
                    )
                )
            );
        }
        else if(!$batch_committee_details = (
            $this->operations->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            )
        )) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare batch committee details. Please 
                        refresh browser."
                    )
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Batch committee details successfully processed."
                    ),
                    "data" => $batch_committee_details
                )
            );
        }
    }

    public function ModifyFrontmen($batch_id)
    {
        $first_frontman = Http::Request(Http::POST, "first-frontman");
        $second_frontman = Http::Request(Http::POST, "second-frontman");
        $third_frontman = Http::Request(Http::POST, "third-frontman");

        $non_colliding = $this->operations->AreFrontmenNonColliding(
            $first_frontman, $second_frontman, $third_frontman
        );

        if(!$non_colliding)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot assign member to 2 or more positions. Please 
                        change entries accordingly."
                    )
                )
            );
        }
        else
        {
            $modify_result = $this->operations->ModifyFrontmen(
                $batch_id, $first_frontman, $second_frontman, $third_frontman
            );

            if($modify_result["status"] === false) 
            {
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, $modify_result["data"]
                );
            }
            else
            {
                Http::Response(Http::OK, $modify_result["data"]);
            }
        }
    }

    public function AddBatchCommitteeMember($batch_id, $committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(!$this->operations->HasCommitteeName($committee_name)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not add batch member using the given 
                        committee name."
                    )
                )
            );
        }
        else if(!$this->operations->BatchMemberInBatch($batch_member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Batch member is not in batch. Nothing to add."
                    )
                )
            );
        }
        else
        {
            $response = $this->operations->AddBatchCommitteeMember(
                $batch_id, $batch_member_id, $committee_name
            );

            if($response["status"] === false)
            {
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, array(
                        "message" => $response["message"]
                    )
                );
            }
            
            $batch_details = $this->operations->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            );

            if(!$batch_details) 
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
                        "message" => $response["message"],
                        "data" => $batch_details
                    )
                );
            }
        }
    }

    public function RemoveBatchCommitteeMember($batch_id, $committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(!$this->operations->HasCommitteeName($committee_name)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not remove batch member from the given 
                        committee name."
                    )
                )
            );
        }
        else if(!$this->operations->BatchMemberInBatch($batch_member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Batch member is not in batch. Nothing to remove."
                    )
                )
            );
        }
        else
        {
            $response = $this->operations->RemoveBatchCommitteeMember(
                $batch_id, $batch_member_id, $committee_name
            );

            if($response["status"] == false)
            {
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, array(
                        "message" => $response["message"]
                    )
                );
            }
            
            $batch_details = $this->operations->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            );

            if(!$batch_details) 
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
                        "message" => $response["message"],
                        "data" => $batch_details
                    )
                );
            }
        }
    }

    public function UpdateBatchCommitteeHead($batch_id, $committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(!$this->operations->HasCommitteeName($committee_name)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not remove batch member from the given 
                        committee name."
                    )
                )
            );
        }
        else if(!$this->operations->BatchMemberInBatch($batch_member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Batch member is not in batch. Nothing to remove."
                    )
                )
            );
        }
        else
        {
            $response = $this->operations->UpdateBatchCommitteeHead(
                $batch_id, $batch_member_id, $committee_name
            );

            if($response["status"] == "error")
            {
                Http::Response(
                    Http::INTERNAL_SERVER_ERROR, array(
                        "message" => $response["message"]
                    )
                );
            }
            
            $batch_details = $this->operations->GetBatchCommitteeDetails(
                $batch_id, $committee_name
            );
            if(!$batch_details) 
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
                        "message" => $response["message"],
                        "data" => $batch_details
                    )
                );
            }
        }
    }
}