<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\TaskActionOperations;

class TaskActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new TaskActionOperations;
    }

    public function GetViewTaskPageDetails()
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

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanViewTaskPageDetails(
                UserSession::GetBatchMemberID(), UserSession::GetBatchID()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadViewTaskPageDetails(
                UserSession::GetBatchMemberID(), UserSession::GetCommitteeID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberViewTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare availability page details. 
                        Please refresh browser."
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
                    "data" => $details
                )
            );
        }
    }

    public function GetAddTaskPageDetails()
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

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadAddTaskPageDetails(
                UserSession::GetCommitteeID(), UserSession::GetBatchMemberID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberAddTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare availability page details. 
                        Please refresh browser."
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
                    "data" => $details
                )
            );
        }
    }

    public function AddTask()
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

        $reporter = UserSession::GetBatchMemberID();

        //$event = Http::Request(Http::POST, "task-event");

        $title = Http::Request(Http::POST, "task-title");
        $description = Http::Request(Http::POST, "task-description");
        $deadline = Http::Request(Http::POST, "task-deadline");
        $assignee = Http::Request(Http::POST, "task-assignee");
        $subscribers = json_decode(
            Http::Request(Http::POST, "task-subscribers"), true
        );

        $validation = $this->operations->ValidateAddTaskData(
            array(
                "task-title"       => $title,
                "task-description" => $description,
                "task-deadline"    => $deadline,
                "task-assignee"    => $assignee,
                "task-subscribers" => $subscribers,
            )
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if(!$this->operations->IsTaskDeadlineValid($deadline))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Task deadline cannot be in the past!"
                    )
                )
            );
        }
        
        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadAddTaskPageDetails(
                UserSession::GetCommitteeID(), UserSession::GetBatchMemberID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberAddTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare availability page details. 
                        Please refresh browser."
                    )
                )
            );
        }
        else if(!$this->operations->IsAssigneeSubordinate($assignee, $details))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Assignee is a non-subordinate! Assignee should be a 
                        subordinate."
                    )
                )
            );
        }
        else if(!$this->operations->IsSubscriberArrayValid(
            $subscribers, $assignee, $reporter
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list is malformed!"
                    )
                )
            );
        }
        else if(!$this->operations->AreSubscribersSubordinates(
            $subscribers, $details
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Subscriber list contain non-subordinates!"
                    )
                )
            );
        }
        
        $parent = Http::Request(Http::POST, "task-parent");

        if(!$this->operations->CheckParentTaskValidByID($parent))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => StringHelper::NoBreakString(
                        "Parent task is not a valid task for a parent!"
                    )
                )
            );
        }
        else if(!$this->operations->AddTask(
            $title, $description, $deadline, $reporter, $assignee, $subscribers,
            $parent
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Could not add task. Please
                        try again."
                    )
                )
            );
        }

        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->operations->GetFrontmanAddTaskPageDetails(
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
                UserSession::IsFirstFrontman()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadAddTaskPageDetails(
                UserSession::GetCommitteeID(), UserSession::GetBatchMemberID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberAddTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare availability page details. 
                        Please refresh browser."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Task successfully added!"
                    ),
                    "data" => $details
                )
            );
        }
    }
}
