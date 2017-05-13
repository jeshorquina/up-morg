<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\StringHelper;
use \Jesh\Helpers\Url;
use \Jesh\Helpers\UserSession;

use \Jesh\Operations\User\CalendarActionOperations;

class CalendarActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new CalendarActionOperations;
    }

    public function GetCalendarEventsPageDetails()
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

        $details = $this->operations->GetCalendarEventsPageDetails(
            UserSession::GetBatchID()
        );
        
        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot prepare availability page details. 
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
                        "Task successfully edited."
                    ),
                    "data" => $details
                )
            );
        }
    }

    public function GetCalendarTasksPageDetails()
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
            $details = $this->operations->GetFrontmanCalendarTaskPageDetails(
                UserSession::GetBatchMemberID(), UserSession::GetBatchID()
            );
        }
        else if(UserSession::IsCommitteeHead())
        {
            $details = $this->operations->GetCommitteeHeadCalendarTaskPageDetails(
                UserSession::GetBatchMemberID(), UserSession::GetCommitteeID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberCalendarTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }
        
        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot prepare availability page details. 
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
                        "Task successfully edited."
                    ),
                    "data" => $details
                )
            );
        }
    }

    public function GetCalendarEventDetailsPageDetails($event_id)
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
        else if(!$this->operations->HasEvent($event_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The event was not found in the database!"
                    )
                )
            );
        }
        else if(!$details = $this->operations->GetCalendarEventDetails(
            $event_id, UserSession::GetBatchID(), 
            UserSession::GetBatchMemberID(), UserSession::GetCommitteeID()
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Cannot prepare availability page details. 
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
                        "Task successfully edited."
                    ),
                    "data" => $details
                )
            );
        }
    }

    public function DeleteCalendarEvent($event_id)
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
        else if(!$this->operations->HasEvent($event_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The event was not found in the database!"
                    )
                )
            );
        }
        else if(!$this->operations->CanEditEventByID(
            $event_id, UserSession::GetBatchID(), 
            UserSession::GetBatchMemberID(), UserSession::GetCommitteeID()
        ))
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this particular task!"
                    )
                )
            );
        }
        else if(!$this->operations->DeleteEvent($event_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot delete event. 
                        Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully deleted event!",
                    "redirect_url" => Url::GetBaseURL("calendar/events")
                )
            );
        }
    }

    public function GetCalendarEventEditDetailsPageDetails($event_id)
    {

    }

    public function EditCalendarEvent($event_id)
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
        else if(!$this->operations->HasEvent($event_id))
        {
            Http::Response(
                Http::NOT_FOUND, array(
                    "message" => StringHelper::NoBreakString(
                        "The event was not found in the database!"
                    )
                )
            );
        }
        else if(!$this->operations->CanEditEventByID(
            $event_id, UserSession::GetBatchID(), 
            UserSession::GetBatchMemberID(), UserSession::GetCommitteeID()
        ))
        {
            
        }
    }
}