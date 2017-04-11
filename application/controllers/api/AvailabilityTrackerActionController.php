<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

use \Jesh\Models\AvailabilityMemberModel;

class AvailabilityTrackerActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("AvailabilityTrackerActionOperations");
    }

    public function UpdateSchedule()
    {
        $monday = Http::Request(Http::POST, "monday-availability");
        $tuesday = Http::Request(Http::POST, "tuesday-availability");
        $wednesday = Http::Request(Http::POST, "wednesday-availability");
        $thursday = Http::Request(Http::POST, "thursday-availability");
        $friday = Http::Request(Http::POST, "friday-availability");
        $saturday = Http::Request(Http::POST, "saturday-availability");
        $sunday = Http::Request(Http::POST, "sunday-availability");

        $user_data = json_decode(Session::Get("user_data"), true);
        $user_id = $user_data["id"];

        $availability = new AvailabilityMemberModel(
            array(
                "BatchMemberID" => (int) $user_id,
                "MondayVector" => $monday,
                "TuesdayVector" => $tuesday,
                "WednesdayVector" => $wednesday,
                "ThursdayVector" => $thursday,
                "FridayVector" => $friday,
                "SaturdayVector" => $saturday,
                "SundayVector" => $sunday 
            )
        );
        if($this->operations->ExistingSchedule($user_id))
        {
            $response = $this->operations->UpdateExistingSchedule($availability, $user_id);
        }
        else{
            $response = $this->operations->UpdateSchedule($availability);
        }


        if(!$response)
        {
            Http::Response(Http::INTERNAL_SERVER_ERROR, 
                "Unable to update availability."
            );
        }
        else 
        {
            Http::Response(Http::CREATED, 
                "Availability successfully updated."
            );
        }
    }

    public function DeleteGroup()
    {

    }

    public function CreateNewGroup()
    {
        
    }
}