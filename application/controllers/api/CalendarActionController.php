<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;

use \Jesh\Models\EventModel;

class CalendarActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("CalendarActionOperations");
    }

    public function AddEvent()
    {
        $event_name = Http::Request(Http::POST, "event_name");
        $event_description = Http::Request(Http::POST, "event_description");
        $event_date_month = Http::Request(Http::POST, "event_date_month");
        $event_date_day = Http::Request(Http::POST, "event_date_day");
        $event_date_year = Http::Request(Http::POST, "event_date_year");
        $event_time_hour = Http::Request(Http::POST, "event_time_hh");
        $event_time_min = Http::Request(Http::POST, "event_time_mm");
        $event_time_am_pm = Http::Request(Http::POST, "event_time_am_pm");
        $event_type = Http::Request(Http::POST, "event_type");

        $validation = $this->operations->ValidateEventData($event_name, $event_description, $event_date_month,
                                                          $event_date_day, $event_date_year, $event_time_hour,
                                                          $event_time_min, $event_time_am_pm, $event_type);

        if($validation["status"] === true)
        {
            if(checkdate($event_date_month, $event_date_day, $event_date_year))
            {
                $event_date = $event_date_month . "-" . $event_date_day . " " . $event_date_year;
                if($this->operations->CheckTime($event_time_hour, $event_time_min, $event_time_am_pm))
                {
                    $event_time = $this->operations->ConvertTimeToMilitary($event_time_hour, $event_time_min, $event_time_am_pm);
                    $response = $this->operations->AddEvent(
                        new EventModel(
                            array(
                                "EventName" => $event_name,
                                "EventDescription" => $event_description,
                                "EventDate" => $event_date,
                                "EventTime" => $event_time,
                                "Timestamp" => "1970-01-01 00:00:01",
                                "IsPublic" => $event_type
                            )
                        )
                    );
                    if(!$response)
                    {
                        Http::Response(Http::INTERNAL_SERVER_ERROR, 
                            "Unable to add event."
                        );
                    }
                    else
                    {
                        Http::Response(Http::CREATED, 
                            "Event successfully added."
                        );
                    }
                }
                else 
                {
                    Http::Response(Http::INTERNAL_SERVER_ERROR, 
                            "Invalid time. Unable to add event."
                        );
                }
            }
            else 
            {
                Http::Response(Http::INTERNAL_SERVER_ERROR, 
                        "Invalid date. Unable to add event."
                    );
            }
        }
        else
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
    }
}