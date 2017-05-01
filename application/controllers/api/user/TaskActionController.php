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
            $details = $this->GetFrontmanAddTaskPageDetails();
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->GetCommitteeHeadAddTaskPageDetails();
        }
        else 
        {
            $details = $this->GetCommitteeMemberAddTaskPageDetails();
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

    private function GetFrontmanAddTaskPageDetails()
    {
        return $this->operations->GetFrontmanAddTaskPageDetails(
            UserSession::GetBatchID(), UserSession::GetBatchMemberID()
        );
    }

    private function GetCommitteeHeadAddTaskPageDetails()
    {
        return $this->operations->GetCommitteeHeadAddTaskPageDetails(
            UserSession::GetCommitteeID(), UserSession::GetBatchMemberID()
        );
    }

    private function GetCommitteeMemberAddTaskPageDetails()
    {
        return $this->operations->GetCommitteeMemberAddTaskPageDetails(
            UserSession::GetBatchMemberID()
        );
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
        //$parent = Http::Request(Http::POST, "task-parent");

        $title = Http::Request(Http::POST, "task-title");
        $description = Http::Request(Http::POST, "task-description");
        $deadline = Http::Request(Http::POST, "task-deadline");
        $assignee = Http::Request(Http::POST, "task-assignee");
        $subscribers = json_decode(
            Http::Request(Http::POST, "task-subscribers"), true
        );

        $validation = $this->operations->ValidateAddTaskData(
            array(
                "title"       => $title,
                "description" => $description,
                "deadline"    => $deadline,
                "assignee"    => $assignee,
                "subscribers" => $subscribers,
            )
        );

        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
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
        else if(!$this->operations->AddTask(
            $title, $description, $deadline, $reporter, $assignee, $subscribers
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something wnet wrong. Could not add task. Please
                        try again."
                    )
                )
            );
        }
        
        $details = array();
        if(UserSession::IsFrontman())
        {
            $details = $this->GetFrontmanAddTaskPageDetails();
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->GetCommitteeHeadAddTaskPageDetails();
        }
        else 
        {
            $details = $this->GetCommitteeMemberAddTaskPageDetails();
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
