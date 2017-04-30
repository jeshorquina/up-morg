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
            UserSession::GetCommitteeID()
        );
    }

    private function GetCommitteeMemberAddTaskPageDetails()
    {
        return $this->operations->GetCommitteeMemberAddTaskPageDetails(
            UserSession::GetBatchMemberID()
        );
    }
}
