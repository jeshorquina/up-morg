<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class UserPagesController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        if(Session::Find("user_data"))
        {
            self::Redirect("home/");
        }
    }

    public function Home()
    {
        self::RenderView(
            "user-pages/home.html.inc", 
            Security::GetCSRFData()
        );
    }

    public function TaskManager()
    {
        self::RenderView(
            "user-pages/task-manager.html.inc", 
            Security::GetCSRFData()
        );
    }

    public function AvailabilityTracker()
    {
        self::RenderView(
            "user-pages/availability-tracker.html.inc", 
            Security::GetCSRFData()
        );
    }

    public function Calendar()
    {
        self::RenderView(
            "user-pages/calendar.html.inc", 
            Security::GetCSRFData()
        );
    }

    public function FinanceTracker()
    {
        self::RenderView(
            "user-pages/finance-tracker.html.inc", 
            Security::GetCSRFData()
        );
    }
}