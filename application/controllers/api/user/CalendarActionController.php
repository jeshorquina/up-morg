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

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Task successfully edited."
                ),
                "data" => $details
            )
        );
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
                UserSession::GetBatchID(), UserSession::GetBatchMemberID(), 
                UserSession::GetCommitteeID()
            );
        }
        else 
        {
            $details = $this->operations->GetCommitteeMemberCalendarTaskPageDetails(
                UserSession::GetBatchMemberID()
            );
        }

        Http::Response(
            Http::OK, array(
                "message" => StringHelper::NoBreakString(
                    "Task successfully edited."
                ),
                "data" => $details
            )
        );
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
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Task successfully edited."
                    ),
                    "data" => $this->operations->GetCalendarEventDetails(
                        $event_id, UserSession::GetBatchID(), 
                        UserSession::GetBatchMemberID(), 
                        UserSession::GetCommitteeID()
                    )
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
        if(!UserSession::IsCommitteeHead() && !UserSession::IsFrontman())
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
                        "Event successfully retrieved."
                    ),
                    "data" => $this->operations->GetEditEventDetails($event_id)
                )
            );
        }
    }

    public function EditCalendarEvent($event_id)
    {
        if(!UserSession::IsCommitteeHead() && !UserSession::IsFrontman())
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
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        
        $event_name = Http::Request(Http::POST, "event-name");
        $event_description = Http::Request(Http::POST, "event-description");
        $event_start_date = Http::Request(Http::POST, "event-start-date");

        $event_end_date = Http::Request(Http::POST, "event-end-date");
        $event_end_date = ($event_end_date == "") ? null : $event_end_date;

        $event_start_time = Http::Request(Http::POST, "event-start-time");
        $event_start_time = ($event_start_time == "") ? null : $event_start_time;

        $event_end_time = Http::Request(Http::POST, "event-end-time");
        $event_end_time = ($event_end_time == "") ? null : $event_end_time;

        $event_visibility = Http::Request(Http::POST, "event-visibility");
        $is_public = ($event_visibility == "public") ? True : False;

        $event_owner = UserSession::GetBatchMemberID();

        $validation = $this->operations->ValidateEventData(
            array(
                "event-name"        => $event_name,
                "event-start-date"  => $event_start_date,
                "event-end-date"    => $event_end_date,
                "event-start-time"  => $event_start_time,
                "event-end-time"    => $event_end_time,
                "event-description" => $event_description,
            )
        );
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if(!$this->operations->HasValidEventDate(
            UserSession::GetBatchID(), $event_start_date, $event_end_date
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array(
                    "message" => StringHelper::NoBreakString(
                        "Event dates are invalid. Please enter valid dates."
                    )
                )
            );
        }
        else if(!$this->operations->EditEvent(
            $event_id, $event_name, $event_start_date, $event_end_date, 
            $event_start_time, $event_end_time, $event_owner, $is_public, 
            $event_description, "event-image"
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot get event. 
                        Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::OK, array(
                    "message" => StringHelper::NoBreakString(
                        "Event successfully edit."
                    ),
                    "data" => $this->operations->GetEditEventDetails($event_id)
                )
            );
        }
    }

    public function AddCalendarEvent()
    {
        if(!UserSession::IsCommitteeHead() && !UserSession::IsFrontman())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }

        $event_name = Http::Request(Http::POST, "event-name");
        $event_description = Http::Request(Http::POST, "event-description");
        $event_start_date = Http::Request(Http::POST, "event-start-date");

        $event_end_date = Http::Request(Http::POST, "event-end-date");
        $event_end_date = ($event_end_date == "") ? null : $event_end_date;

        if($event_start_date == $event_end_date)
        {
            $event_end_date = null;
        }

        $event_start_time = Http::Request(Http::POST, "event-start-time");
        $event_start_time = ($event_start_time == "") ? null : $event_start_time;

        $event_end_time = Http::Request(Http::POST, "event-end-time");
        $event_end_time = ($event_end_time == "") ? null : $event_end_time;

        $event_visibility = Http::Request(Http::POST, "event-visibility");
        $is_public = ($event_visibility == "public") ? True : False;

        $event_owner = UserSession::GetBatchMemberID();

        $validation = $this->operations->ValidateEventData(
            array(
                "event-name"        => $event_name,
                "event-start-date"  => $event_start_date,
                "event-end-date"    => $event_end_date,
                "event-start-time"  => $event_start_time,
                "event-end-time"    => $event_end_time,
                "event-description" => $event_description,
            )
        );
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        else if(!$this->operations->HasValidEventDate(
            UserSession::GetBatchID(), $event_start_date, $event_end_date
        ))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, 
                array(
                    "message" => StringHelper::NoBreakString(
                        "Event dates are invalid. Please enter valid dates."
                    )
                )
            );
        }

        if(!$event_id = $this->operations->AddEvent(
            $event_name, $event_start_date, $event_end_date, $event_start_time, 
            $event_end_time, $event_owner, $is_public, $event_description,
            "event-image"
        ))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Something went wrong. Cannot get event. 
                        Please try again."
                    )
                )
            );
        }
        else
        {
            Http::Response(
                Http::CREATED, array(
                    "message" => StringHelper::NoBreakString(
                        "Event successfully added."
                    ),
                    "redirect_url" => Url::GetBaseURL(
                        sprintf('calendar/events/details/%s', $event_id)
                    )
                )
            );
        }
    }
}