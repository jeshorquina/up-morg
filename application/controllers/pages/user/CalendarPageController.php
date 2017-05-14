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
        Url::Redirect("calendar/tasks");
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
                        "title" => "Calendar",
                        "urls" => array(
                            "calendar_page" => Url::GetBaseURL("calendar/events")
                        ),
                        "details" => array(
                            "event_id" => $event_id
                        )
                    )
                ),
            );

            self::SetBody("user/calendar/event/view.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData("calendar-event-view", $other_details)
            );
        }
    }

    public function EditCalendarEventDetailsPage($event_id)
    {
        if(PageRenderer::HasCalendarEditPageAccess($event_id))
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Calendar",
                        "urls" => array(
                            "calendar_page" => Url::GetBaseURL("calendar/events"),
                            "event_view_page" => Url::GetBaseURL(
                                sprintf(
                                    "calendar/events/details/%s", $event_id
                                )
                            )
                        ),
                        "details" => array(
                            "event_id" => $event_id
                        )
                    )
                ),
            );

            self::SetBody("user/calendar/event/edit.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "calendar-event-edit", $other_details
                )
            );
        }
    }

    public function AddCalendarEventPage()
    {
        if(PageRenderer::HasCalendarAddPageAccess())
        {
            $other_details = array(
                Security::GetCSRFData(),
                array(
                    "page" => array(
                        "title" => "Calendar"
                    )
                ),
            );

            self::SetBody("user/calendar/event/add.html.inc");
            self::RenderView(
                PageRenderer::GetUserPageData(
                    "calendar-event-add", $other_details
                )
            );
        }
    }
}