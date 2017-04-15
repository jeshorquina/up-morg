<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class AvailabilityTrackerPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function AvailabilityTracker()
    {
        self::SetBody("user-pages/availability-tracker.html.inc");
        self::RenderView(Security::GetCSRFData());
    }

    public function AddCustomGroup()
    {
        self::SetBody("user-pages/minor-pages/add-custom-group.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}