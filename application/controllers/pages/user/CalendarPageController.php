<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class CalendarPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Calendar()
    {
        self::SetBody("user/calendar.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}