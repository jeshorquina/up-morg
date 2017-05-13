<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\StringHelper;
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


    // public function AddEvent()
    // {
    //     $event_name = Http::Request(Http::POST, "event_name");
    //     $event_description = Http::Request(Http::POST, "event_description");
    //     $event_date_month = Http::Request(Http::POST, "event_date_month");
    //     $event_date_day = Http::Request(Http::POST, "event_date_day");
    //     $event_date_year = Http::Request(Http::POST, "event_date_year");
    //     $event_time_hour = Http::Request(Http::POST, "event_time_hh");
    //     $event_time_min = Http::Request(Http::POST, "event_time_mm");
    //     $event_time_am_pm = Http::Request(Http::POST, "event_time_am_pm");
    //     $event_type = Http::Request(Http::POST, "event_type");

    //     $validation = $this->operations->ValidateEventData($event_name, $event_description, $event_date_month,
    //                                                       $event_date_day, $event_date_year, $event_time_hour,
    //                                                       $event_time_min, $event_time_am_pm, $event_type);

    //     $user_data = json_decode(Session::Get("user_data"), true);
    //     $user_id = $user_data["id"];

    //     if($validation["status"] === true)
    //     {
    //         if(checkdate($event_date_month, $event_date_day, $event_date_year))
    //         {
    //             $event_date = $event_date_year . "-" . $event_date_month . "-" . $event_date_day;
    //             if($this->operations->CheckTime($event_time_hour, $event_time_min, $event_time_am_pm))
    //             {
    //                 $event_time = $this->operations->ConvertTimeToMilitary($event_time_hour, $event_time_min, $event_time_am_pm);
    //                 $array = array(
    //                             "EventOwner" => (int) $user_id, 
    //                             "EventName" => $event_name,
    //                             "EventDescription" => $event_description,
    //                             "EventDate" => $event_date,
    //                             "EventTime" => $event_time,
    //                             "IsPublic" => $event_type
    //                         );
    //                 $response = $this->operations->AddEvent(
    //                     new EventModel(
    //                         $array
    //                     )
    //                 );
    //                 if(!$response)
    //                 {
    //                     Http::Response(Http::INTERNAL_SERVER_ERROR, 
    //                         "Unable to add event." . json_encode($array)
    //                     );
    //                 }
    //                 else
    //                 {
    //                     Http::Response(Http::CREATED, 
    //                         "Event successfully added."
    //                     );
    //                 }
    //             }
    //             else 
    //             {
    //                 Http::Response(Http::INTERNAL_SERVER_ERROR, 
    //                         "Invalid time. Unable to add event."
    //                     );
    //             }
    //         }
    //         else 
    //         {
    //             Http::Response(Http::INTERNAL_SERVER_ERROR, 
    //                     "Invalid date. Unable to add event."
    //                 );
    //         }
    //     }
    //     else
    //     {
    //         Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
    //     }
    // }
}