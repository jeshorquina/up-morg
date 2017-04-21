<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\SubordinateActionOperations;

class SubordinateActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess("subordinate")) 
        {
            $this->operations = new SubordinateActionOperations;
        }
    }

    public function GetBatchDetails()
    {
        if(UserSession::IsFirstFrontman())
        {
            $this->GetFirstFrontmanBatchDetails();
        }
        else if(UserSession::IsFrontman())
        {
            $this->GetFrontmanBatchDetails();
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->GetCommitteeHeadBatchDetails();
        }
        else 
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "User does not have permission for this action!"
                    )
                )
            );
        }
    }

    private function GetFirstFrontmanBatchDetails()
    {
        $batch_details = (
            $this->operations->GetFirstFrontmanBatchDetails(
                UserSession::GetBatchID()
            )
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
                    "message" => "Batch details successfully processed.",
                    "data" => $batch_details
                )
            );
        }
    }

    private function GetFrontmanBatchDetails()
    {
        $batch_details = (
            $this->operations->GetFrontmanBatchDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID()
            )
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
                    "message" => "Batch details successfully processed.",
                    "data" => $batch_details
                )
            );
        }
    }

    private function GetCommitteeHeadBatchDetails()
    {
        $batch_details = (
            $this->operations->GetCommitteeHeadBatchDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID()
            )
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
                    "message" => "Batch details successfully processed.",
                    "data" => $batch_details
                )
            );
        }
    }

    public function AddMemberToBatch()
    {
        $member_id = Http::Request(Http::POST, "member-id");
        $batch_id = UserSession::GetBatchID();

        if(!UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "User does not have permission to add member to batch!"
                    )
                )
            );
        }
        else if($this->operations->MemberInBatch($batch_id, $member_id)) 
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
        else if(!$batch_details = (
            $this->operations->GetFirstFrontmanBatchDetails(
                $batch_id
            )
        )) 
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

    public function RemoveMemberFromBatch()
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");
        $batch_id = UserSession::GetBatchID();

        if(!UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "User does not have permission to add member to batch!"
                    )
                )
            );
        }
        else if(!$this->operations->BatchMemberInBatch($batch_member_id)) 
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
        else if(!$batch_details = (
            $this->operations->GetFirstFrontmanBatchDetails(
                $batch_id
            )
        )) 
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

    public function GetCommitteeDetails($committee_name)
    {
        if($committee_name === "frontman")
        {
            $this->GetFrontmanDetails();
        }
        else if(UserSession::IsFirstFrontman())
        {
            $this->GetFirstFrontmanCommitteeDetails($committee_name);
        }
        else if(UserSession::IsFrontman())
        {
            $this->GetFrontmanCommitteeDetails($committee_name);
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->GetCommitteeHeadCommitteeDetails($committee_name);
        }
        else 
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "User does not have permission for this action!"
                    )
                )
            );
        }
    }

    private function GetFirstFrontmanCommitteeDetails($committee_name)
    {
        $committee_details = (
            $this->operations->GetFirstFrontmanCommitteeDetails(
                UserSession::GetBatchID(), $committee_name
            )
        );

        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please refresh
                        browser."
                    )
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Committee details successfully processed.",
                    "data" => $committee_details
                )
            );
        }
    }

    private function GetFrontmanCommitteeDetails($committee_name)
    {
        if(!$this->operations->HasCommitteeAccess(
            UserSession::GetBatchID(),
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }

        $committee_details = (
            $this->operations->GetFrontmanCommitteeDetails(
                UserSession::GetBatchID(),
                UserSession::GetBatchMemberID(),
                $committee_name
            )
        );

        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please refresh
                        browser."
                    )
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Committee details successfully processed.",
                    "data" => $committee_details
                )
            );
        }
    }

    private function GetCommitteeHeadCommitteeDetails($committee_name)
    {
        if(!$this->operations->IsCommitteeHead(
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        
        $committee_details = (
            $this->operations->GetCommitteeHeadCommitteeDetails(
                UserSession::GetBatchID(),
                UserSession::GetBatchMemberID(),
                $committee_name
            )
        );

        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please refresh
                        browser."
                    )
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Committee details successfully processed.",
                    "data" => $committee_details
                )
            );
        }
    }
    
    public function AddMemberToCommittee($committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");
        $batch_id = UserSession::GetBatchID();

        if(UserSession::IsFirstFrontman())
        {
            $this->FirstFrontmanAddMemberToCommittee(
                $batch_id, $batch_member_id, $committee_name
            );
        }
        else if(UserSession::IsFrontman())
        {
            $this->FrontmanAddMemberToCommittee(
                $batch_id, $batch_member_id, $committee_name
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->CommitteeHeadAddMemberToCommittee(
                $batch_id, $batch_member_id, $committee_name
            );
        }
        else
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => sprintf(
                        StringHelper::NoBreakString(
                            "User does not have permission to add a member to 
                            the %s committee!"
                        )
                    ), $committee_name
                )
            );
        }
    }

    private function FirstFrontmanAddMemberToCommittee(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        $is_added = $this->operations->AddMemberToCommittee(
            $batch_member_id, $committee_name
        );

        if(!$is_added)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not add batch member to committee. Please try
                        again."
                    )
                )
            );
        }

        $committee_details = false;
        if(UserSession::IsFirstFrontman())
        {
            $committee_details = (
                $this->operations->GetFirstFrontmanCommitteeDetails(
                    UserSession::GetBatchID(), $committee_name
                )
            );
        }
        else if(UserSession::IsFrontman())
        {
            $committee_details = (
                $this->operations->GetFrontmanCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $committee_details = (
                $this->operations->GetCommitteeHeadCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }

        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please 
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
                        "Batch member successfully added to committee."
                    ),
                    "data" => $committee_details
                )
            );
        }
    }

    private function FrontmanAddMemberToCommittee(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->HasCommitteeAccess(
            UserSession::GetBatchID(),
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        else
        {
            $this->FirstFrontmanAddMemberToCommittee(
                $batch_id, $batch_member_id, $committee_name
            );
        }
    }

    private function CommitteeHeadAddMemberToCommittee(
        $batch_id, $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->IsCommitteeHead(
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        else
        {
            $this->FirstFrontmanAddMemberToCommittee(
                $batch_id, $batch_member_id, $committee_name
            );
        }
    }

    public function RemoveMemberFromCommittee($committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(UserSession::IsFirstFrontman())
        {
            $this->FirstFrontmanRemoveMemberFromCommittee(
                $batch_member_id, $committee_name
            );
        }
        else if(UserSession::IsFrontman())
        {
            $this->FrontmanRemoveMemberFromCommittee(
                $batch_member_id, $committee_name
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $this->CommitteeHeadRemoveMemberFromCommittee(
                $batch_member_id, $committee_name
            );
        }
        else
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => sprintf(
                        StringHelper::NoBreakString(
                            "User does not have permission to remove a member to 
                            the %s committee!"
                        )
                    ), $committee_name
                )
            );
        }
    }

    private function FirstFrontmanRemoveMemberFromCommittee(
        $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->IsCommitteeMember(
            $batch_member_id, $committee_name
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Batch member not part of the committee!"
                    )
                )
            );
        }
        else if(!$this->operations->IsMemberTypeCommitteeMember(
            $batch_member_id
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot delete other roles aside from committee members.
                        Please change role of the user to committee member first 
                        before deleting."
                    )
                )
            );
        }
        
        $is_removed = $this->operations->RemoveMemberFromCommittee(
            $batch_member_id
        );

        if(!$is_removed)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not remove batch member to committee. Please try
                        again."
                    )
                )
            );
        }
        
        $committee_details = false;
        if(UserSession::IsFirstFrontman())
        {
            $committee_details = (
                $this->operations->GetFirstFrontmanCommitteeDetails(
                    UserSession::GetBatchID(), $committee_name
                )
            );
        }
        else if(UserSession::IsFrontman())
        {
            $committee_details = (
                $this->operations->GetFrontmanCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $committee_details = (
                $this->operations->GetCommitteeHeadCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }

        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please 
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
                        "Batch member successfully removed from committee."
                    ),
                    "data" => $committee_details
                )
            );
        }
    }

    private function FrontmanRemoveMemberFromCommittee(
        $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->HasCommitteeAccess(
            UserSession::GetBatchID(),
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        else 
        {
            $this->FirstFrontmanRemoveMemberFromCommittee(
                $batch_member_id, $committee_name
            );
        }
    }

    private function CommitteeHeadRemoveMemberFromCommittee(
        $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->IsCommitteeHead(
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        else
        {
            $this->FirstFrontmanRemoveMemberFromCommittee(
                $batch_member_id, $committee_name
            );
        }
    }

    public function AssignCommitteeHead($committee_name)
    {
        $batch_member_id = Http::Request(Http::POST, "batch-member-id");

        if(UserSession::IsFirstFrontman())
        {
            $this->FirstFrontmanAssignCommitteeHead(
                $batch_member_id, $committee_name
            );
        }
        else if(UserSession::IsFrontman())
        {
            $this->FrontmanAssignCommitteeHead(
                $batch_member_id, $committee_name
            );
        }
        else
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => sprintf(
                        StringHelper::NoBreakString(
                            "User does not have permission to remove a member to 
                            the %s committee!"
                        )
                    ), $committee_name
                )
            );
        }
    }
    
    private function FirstFrontmanAssignCommitteeHead(
        $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->IsMemberTypeCommitteeMember($batch_member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot make other roles aside from committee members a 
                        committee head."
                    )
                )
            );
        }
        else if(!$this->operations->AssignCommitteeHead(
            $batch_member_id, $committee_name
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot make committee member committee head."
                    )
                )
            );
        }
        
        $committee_details = false;
        if(UserSession::IsFirstFrontman())
        {
            $committee_details = (
                $this->operations->GetFirstFrontmanCommitteeDetails(
                    UserSession::GetBatchID(), $committee_name
                )
            );
        }
        else if(UserSession::IsFrontman())
        {
            $committee_details = (
                $this->operations->GetFrontmanCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $committee_details = (
                $this->operations->GetCommitteeHeadCommitteeDetails(
                    UserSession::GetBatchID(),
                    UserSession::GetBatchMemberID(),
                    $committee_name
                )
            );
        }
        
        if(!$committee_details) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare committee details. Please 
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
                        "Batch member successfully changed to committee head."
                    ),
                    "data" => $committee_details
                )
            );
        }
    }

    private function FrontmanAssignCommitteeHead(
        $batch_member_id, $committee_name
    )
    {
        if(!$this->operations->HasCommitteeAccess(
            UserSession::GetBatchID(),
            UserSession::GetBatchMemberID(), 
            $committee_name
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "Could are not allowed to access this endpoint!"
                    )
                )
            );
        }
        else 
        {
            $this->FirstFrontmanAssignCommitteeHead(
                $batch_member_id, $committee_name
            );
        }
    }

    private function GetFrontmanDetails()
    {
        if(!UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => sprintf(
                        StringHelper::NoBreakString(
                            "User does not have permission to access 
                            this endpoint!"
                        )
                    ), $committee_name
                )
            );
        }
        
        $frontman_details = $this->operations->GetFrontmanDetails(
            UserSession::GetBatchID()
        );

        if(!$frontman_details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare frontman details. Please 
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
                        "Frontman details successfully prepared."
                    ),
                    "data" => $frontman_details
                )
            );
        }
    }

    public function ModifyFrontman()
    {
        if(!UserSession::IsFirstFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => sprintf(
                        StringHelper::NoBreakString(
                            "User does not have permission to access 
                            this endpoint!"
                        )
                    ), $committee_name
                )
            );
        }

        $second = Http::Request(Http::POST, "second-frontman");
        $third = Http::Request(Http::POST, "third-frontman");

        if($second == $third)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Second and third frontmen should not be the same."
                    )
                )
            );
        }
        else if($second == 0 || $third == 0)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Second and third frontmen should have a value."
                    )
                )
            );
        }
        else if(!$this->operations->ModifyFrontman(
            UserSession::GetBatchID(), $second, $third
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not modify the frontmen. Please 
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
                        "Frontman has been successfully modified."
                    )
                )
            );
        }
    }
}
