<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Url;
use \Jesh\Helpers\UserSession;

class IndexController extends Controller 
{
    public function index()
    {
        Url::Redirect("events");
    }

    public function UserHomepage()
    {
        if(!UserSession::IsBatchMember())
        {
            Url::Redirect("request/batch");
        }
        else if(!UserSession::IsCommitteeMember() && !UserSession::IsFrontman())
        {
            Url::Redirect("request/committee");
        }
        else
        {
            Url::Redirect("task");
        }
    }
}
