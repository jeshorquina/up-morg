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

        $this->operations = self::InitializeOperations("UserActionOperations");

        if(!Session::Find("user_data"))
        {
            self::Redirect("/");
        }

        self::SetHeader(
            array(
                "user-pages/templates/header.html.inc",
                "user-pages/templates/nav.html.inc"
            )
        );
        self::SetFooter(
            "user-pages/templates/footer.html.inc"
        );
    }

    public function Home()
    {
        $view_data = array();
        $view_data["page"]["title"] = "Home";

        self::SetBody("user-pages/home.html.inc");
        self::RenderView($view_data);
    }

    public function TaskManager()
    {
        $view_data = array();
        $member = 0;

        self::SetBody("user-pages/task-manager.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            $members = $this->operations->GetMembers(),
            array(
                "page" => array(
                    "title" => "Task Manager",
                    "stylesheet" => base_url("public/css/signup.css"),
                    "members" => $this->operations->GetMembers()
                )
            )
        ));
    }

    public function AvailabilityTracker()
    {
        $view_data = array();

        self::SetBody("user-pages/availability-tracker.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Availability Tracker",
                    "stylesheet" => base_url("public/css/signup.css")
                )
            )
        ));
    }

    public function Calendar()
    {
        $view_data = array();

        self::SetBody("user-pages/calendar.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Calendar",
                    "stylesheet" => base_url("public/css/signup.css")
                )
            )
        ));
    }

    public function FinanceTracker()
    {
        $view_data = array();

        self::SetBody("user-pages/finance-tracker.html.inc");
        self::RenderView(array_merge(
            Security::GetCSRFData(),
            array(
                "page" => array(
                    "title" => "Finance Tracker",
                    "stylesheet" => base_url("public/css/signup.css")
                )
            )
        ));
    }
}