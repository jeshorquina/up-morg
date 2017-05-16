<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\AvailabilityActionOperations;

class AvailabilityActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new AvailabilityActionOperations;
    }

    public function GetAvailability()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Availability page details successfully processed."
                    ),
                    "data" => $this->operations->GetAvailability(
                        UserSession::GetBatchMemberID()
                    )
                )
            );
        }
    }

    public function UpdateAvailability()
    {
        if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $schedule = json_decode(Http::Request(Http::POST, "data"), true);
        
        if(!$this->operations->UpdateAvailability(
            $schedule, UserSession::GetBatchMemberID()
        )) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot update availability. 
                        Please Try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Availability successfully updated!"
                    )
                )
            );
        }
    }

    public function GetCommitteeAvailability()
    {
        if(!UserSession::IsCommitteeMember())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Availability group view details successfully 
                        processed."
                    ),
                    "data" => (
                        $this->operations->GetAvailabilityCommitteeDetails(
                            UserSession::GetCommitteeID(), 
                            UserSession::GetBatchID()
                        )
                    )
                )
            );
        }
    }

    public function GetAvailabilityGroupDetails()
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Group availability page details successfully 
                        processed."
                    ),
                    "data" => $this->operations->GetAvailabilityGroups(
                        UserSession::GetBatchMemberID()
                    )
                )
            );
        }
    }

    public function AddAvailabilityGroup()
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $group_name = Http::Request(Http::POST, "group-name");

        if(trim($group_name) === "")
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY,
                array(
                    "message" => "Group name cannot empty!"
                )
            );
        }
        else if(!$this->operations->AddAvailabilityGroup(
            UserSession::GetBatchMemberID(), $group_name
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot add availability group. 
                        Please Try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => "Availability group successfully added.",
                    "data" =>  $this->operations->GetAvailabilityGroups(
                        UserSession::GetBatchMemberID()
                    )
                )
            );
        }
    }

    public function DeleteAvailabilityGroup()
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $group_id = Http::Request(Http::POST, "group-id");

        if(!$this->operations->CheckGroupOwnership(
            $group_id, UserSession::GetBatchMemberID()
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot delete selected availability group."
                    )
                )
            );
        }
        else if(!$this->operations->DeleteAvailabilityGroup($group_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot add availability group. 
                        Please Try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Availability group successfully deleted.",
                    "data" => $this->operations->GetAvailabilityGroups(
                        UserSession::GetBatchMemberID()
                    )
                )
            );
        }
    }

    public function GetViewAvailabilityGroupDetails($group_id)
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->CheckGroupOwnership(
            $group_id, UserSession::GetBatchMemberID()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this specific group!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Availability group view details successfully 
                        processed."
                    ),
                    "data" => (
                        $this->operations->GetAvailabilityGroupViewDetails(
                            $group_id
                        )
                    )
                )
            );
        }
    }

    public function GetEditAvailabilityGroupDetails($group_id)
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->CheckGroupOwnership(
            $group_id, UserSession::GetBatchMemberID()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this specific group!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Availability group edit details successfully 
                        processed."
                    ),
                    "data" => (
                        $this->operations->GetAvailabilityGroupEditDetails(
                            $group_id, UserSession::GetBatchID(),
                            UserSession::GetBatchMemberID(), 
                            UserSession::IsFirstFrontman()
                        )
                    )
                )
            );
        }
    }

    public function AddAvailabilityGroupMember($group_id)
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->CheckGroupOwnership(
            $group_id, UserSession::GetBatchMemberID()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this specific group!"
                    )
                )
            );
        }

        $member_id = Http::Request(Http::POST, "member-id");

        if(!$this->operations->HasAvailabilityMember($member_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is not present in the database!"
                    )
                )
            );
        }
        else if($this->operations->HasAvailabilityGroupMember(
            $group_id, $member_id
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is already in the group!"
                    )
                )
            );
        }
        else if(!$this->operations->AddGroupMember($group_id, $member_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot add member to group. Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Member successfully added to group!"
                    ),
                    "data" => (
                        $this->operations->GetAvailabilityGroupEditDetails(
                            $group_id, UserSession::GetBatchID(),
                            UserSession::GetBatchMemberID(), 
                            UserSession::IsFirstFrontman()
                        )
                    )
                )
            );
        }
    }
    
    public function DeleteAvailabilityGroupMember($group_id)
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else if(!$this->operations->CheckGroupOwnership(
            $group_id, UserSession::GetBatchMemberID()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this specific group!"
                    )
                )
            );
        }

        $member_id = Http::Request(Http::POST, "member-id");

        if(!$this->operations->HasAvailabilityMember($member_id))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is not present in the database!"
                    )
                )
            );
        }
        else if(!$this->operations->HasAvailabilityGroupMember(
            $group_id, $member_id
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Member is not part of the group!"
                    )
                )
            );
        }
        else if(!$this->operations->DeleteGroupMember($group_id, $member_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot delete member to group. Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Member successfully deleted from group!"
                    ),
                    "data" => (
                        $this->operations->GetAvailabilityGroupEditDetails(
                            $group_id, UserSession::GetBatchID(),
                            UserSession::GetBatchMemberID(), 
                            UserSession::IsFirstFrontman()
                        )
                    )
                )
            );
        }
    }

    public function GetMemberAvailability()
    {
        if(!UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Member availability page details successfully 
                        processed."
                    ),
                    "data" => (
                        $this->operations->GetMemberAvailability(
                            UserSession::GetBatchID(), 
                            UserSession::GetBatchMemberID(),
                            UserSession::IsFirstFrontman()
                        )
                    )
                )
            );
        }
    }
}