<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\StringHelper;

use \Jesh\Operations\Admin\MemberActionOperations;

class MemberActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasAdminPageAccess())
        {
            $this->operations = new MemberActionOperations;
        }
    }

    public function GetMembers()
    {
        if(!$members = $this->operations->GetMembers()) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get members. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Members successfully retrieved.",
                    "data" => $members
                )
            );
        }
    }

    public function DeleteMember()
    {
        $member_id = Http::Request(Http::POST, "member-id");

        if(!$this->operations->ExistingMemberByID($member_id)) 
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "message" => "Member selected is not present in database."
                )
            );
        }
        else if(!$this->operations->DeleteMember($member_id))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to delete selected member. Please try again."
                    )
                )
            );
        }
        elseif(!$members = $this->operations->GetMembers())
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Unable to get members. Please try again."
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully deleted member.",
                    "data" => $members
                )
            );
        }
    }

    public function GetMemberDetails($member_id)
    {
        if(!$member = $this->operations->GetMemberDetails($member_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to get member details. Please try again."
                    )
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully retrieved member details.",
                    "data" => $member
                )
            );
        }
    }

    public function ModifyMemberDetails($member_id)
    {
        $first_name = Http::Request(Http::POST, "first-name");
        $middle_name = Http::Request(Http::POST, "middle-name");
        $last_name = Http::Request(Http::POST, "last-name");
        $email_address = Http::Request(Http::POST, "email-address");
        $phone_number = Http::Request(Http::POST, "phone-number");

        $member_array = array(
            "id" => $member_id, 
            "first-name" => $first_name,
            "last-name" => $last_name, 
            "email-address" => $email_address, 
            "phone-number" => $phone_number
        );

        $validation = $this->operations->ValidateMemberDetails($member_array);

        if($validation["status"] === false) 
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["message"]);
        }
        
        $member_array["middle-name"] = $middle_name;
        
        if(!$this->operations->ModifyMemberDetails($member_array))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to update member details. Please try again."
                    )
                )
            );
        }
        else if(!$member = $this->operations->GetMemberDetails($member_id)) 
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => StringHelper::NoBreakString(
                        "Unable to get member details. Please try again."
                    )
                )    
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Successfully modified member details.",
                    "data" => $member
                )
            );
        }
    }
}