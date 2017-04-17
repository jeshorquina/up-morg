<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Url;

use \Jesh\Operations\Admin\AccountActionOperations;

class AccountActionController extends Controller
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasAdminPageAccess())
        {
            $this->operations = new AccountActionOperations;
        }
    }

    public function ChangePassword()
    {
        $old_password     = Http::Request(Http::POST, "old-password");
        $new_password     = Http::Request(Http::POST, "new-password");
        $confirm_password = Http::Request(Http::POST, "confirm-password");

         $validation = $this->operations->ValidateUpdatePasswordData(
            array(
                "old-password" => $old_password,
                "new-password" => $new_password,
                "confirm-password" => $confirm_password,
            )    
        );
        
        if($validation["status"] === false)
        {
            Http::Response(Http::UNPROCESSABLE_ENTITY, $validation["data"]);
        }
        else if($new_password !== $confirm_password)
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "new-password" => "Passwords does not match!",
                    "confirm-password" => "Passwords does not match!"
                )
            );
        }
        else if(!$this->operations->MatchingPassword($old_password))
        {
            Http::Response(
                Http::UNPROCESSABLE_ENTITY, array(
                    "old-password" => "Invalid old password provided."
                )
            );
        }
        else if(!$this->operations->ChangePassword($new_password))
        {
            Http::Response(
                Http::INTERNAL_SERVER_ERROR, array(
                    "message" => "Something went wrong. Password not changed."
                )
            );
        }
        else 
        {
            Http::Response(
                Http::OK, array(
                    "message" => "Password has successfully been changed.",
                    "redirect_url" => Url::GetBaseURL("action/admin/logout")
                )
            );
        }
    }
}