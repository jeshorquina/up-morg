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
        self::SetBody("user-pages/home.html.inc");
        self::RenderView(array(
            "page" => array(
                "title" => "Home"
            )
        ));
    }

    public function TaskManager()
    {
        self::SetBody("user-pages/task-manager.html.inc");
        self::RenderView(array(
            "page" => array(
                "title" => "Task Manager"
            )
        ));
    }

    public function AvailabilityTracker()
    {
        self::SetBody("user-pages/availability-tracker.html.inc");
        self::RenderView(array(
            "page" => array(
                "title" => "Availability Tracker"
            )
        ));
    }

    public function Calendar()
    {
        self::SetBody("user-pages/calendar.html.inc");
        self::RenderView(array(
            "page" => array(
                "title" => "Calendar"
            )
        ));
    }

    public function FinanceTracker()
    {
        self::SetBody("user-pages/finance-tracker.html.inc");
        self::RenderView(array(
            "page" => array(
                "title" => "Finance Tracker"
            )
        ));
    }
}
