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
        self::SetBody("user/availability-tracker.html.inc");
        self::RenderView(Security::GetCSRFData());
    }

    public function AddCustomGroup()
    {
        self::SetBody("user/subdirectory/add-custom-group.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}