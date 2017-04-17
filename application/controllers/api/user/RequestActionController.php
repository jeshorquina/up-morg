<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\StringHelper;

use \Jesh\Operations\User\RequestActionOperations;

class RequestActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess(
            self::GetBaseURL(), "request-committee"
        )) 
        {
            $this->operations = new RequestActionOperations;
        }
    }

    public function GetCommittees()
    {
        if(!$committees = $this->operations->GetCommittees()) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get committes. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Committees successfully retrieved.",
                    "data" => $committees
                )
            );
        }
    }

    public function RequestCommittee()
    {
        $committee_id = Http::Request(Http::POST, "committee-id");

        if(!$this->operations->RequestCommittee($committee_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to update committee request. 
                        Please try again."
                    )
                )    
            );
        }
        else if(!$committees = $this->operations->GetCommittees()) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get committees. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Committee membership successfully requested.",
                    "data" => $committees
                )
            );
        }
    }
}