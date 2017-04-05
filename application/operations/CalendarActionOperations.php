<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Repository\CalendarActionOperationsRepository;

use \Jesh\Models\EventModel;

class CalendarActionOperations
{
    public function __construct()
    {
        $this->repository = new CalendarActionOperationsRepository;
    }

    public function ValidateEventData($name, $description, $month, $day, $year, $time_hour, $time_min,
                                      $time_am_pm, $type)
    {
        $validation = new ValidationDataBuilder;
        $validation->CheckString("name", $name);
        $validation->CheckString("description", $description);
        $validation->CheckString("month", $month);
        $validation->CheckString("day", $day);
        $validation->CheckString("year", $year);
        $validation->CheckString("hour format", $time_hour);
        $validation->CheckString("minute format", $time_min);
        $validation->CheckString("am/pm format", $time_am_pm);

        return array(
            "status"  => $validation->GetStatus(),
            "message" => $validation->GetValidationData()
        );
    }

    public function CheckTime($hour, $min, $am_pm)
    {
        if($am_pm == "")
        {
            if ($hour < 0 || $hour > 23 || !is_numeric($hour)) 
            {
                return false;
            }  
        }
        else
        {
            if ($hour < 0 || $hour > 12 || !is_numeric($hour)) 
            {
                return false;
            }  
        }
        if ($min < 0 || $min > 59 || !is_numeric($min)) 
        {
            return false;
        }
        return true;
     }

     public function ConvertTimeToMilitary($hour, $min, $am_pm)
     {
         $sec = "00";
         if(strtolower($am_pm) == "pm" )
         {
             if($hour != "12")
             {
                 $hour = (int)$hour + 12;
             }
         }
         else
         {
             if($hour == "12")
             {
                 $hour = "00";
             }
         }
         return $time = $hour . ":" . $min . ":" . $sec;
     }

     public function AddEvent(Eventmodel $event)
     {
         return $this->repository->AddEvent($event);
     }
}

