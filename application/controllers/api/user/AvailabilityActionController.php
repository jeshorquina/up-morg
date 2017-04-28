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
        if(!UserSession::IsBatchMember())
        {
            Http::Response(
                Http::FORBIDDEN, array(
                    "message" => StringHelper::NoBreakString(
                        "You do not have access to this endpoint!"
                    )
                )
            );
        }
        
        $details = $this->operations->GetAvailability(
            UserSession::GetBatchMemberID()
        );
        
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

    public function UpdateAvailability()
    {
        if(!UserSession::IsBatchMember())
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
                        "Could not update availability. 
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

    }

    public function GetAvailabilityGroupDetails()
    {

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

        $details = $this->operations->GetMemberAvailability(
            UserSession::GetBatchID(), UserSession::GetBatchMemberID(),
            UserSession::IsFirstFrontman()
        );
        
        if(!$details)
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Could not prepare member availability page details. 
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
                        "Member availability page details successfully 
                        processed."
                    ),
                    "data" => $details
                )
            );
        }
    }
}