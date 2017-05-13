<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PageRenderer;
use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\Url;

class CalendarPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->SetTemplates();
    }

    private function SetTemplates()
    {
        self::SetHeader("templates/header.html.inc");
        self::SetHeader("templates/nav.html.inc");
        self::SetFooter("templates/footer.html.inc");
    }

    public function CalendarIndex()
    {
        Url::Redirect("calendar/events");
    }

    public function ViewCalendarTasksPage()
    {
        if(PageRenderer::HasCalendarViewPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Calendar"
                    )
                ),
            );

            self::SetBody("user/calendar/main.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("calendar-tasks", $other_details)
            );
        }
    }

    public function ViewCalendarEventsPage()
    {
        if(PageRenderer::HasCalendarViewPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Calendar"
                    )
                ),
            );

            self::SetBody("user/calendar/main.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("calendar-events", $other_details)
            );
        }
    }

    public function ViewCalendarEventDetailsPage($event_id)
    {
        if(PageRenderer::HasCalendarViewPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Calendar"
                    )
                ),
            );

            self::SetBody("user/calendar/event/view.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("calendar-event-view", $other_details)
            );
        }
    }
}