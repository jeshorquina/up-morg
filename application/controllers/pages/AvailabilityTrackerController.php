<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class AvailabilityTrackerController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function AddCustomGroup()
    {
        self::SetBody("user-pages/minor-pages/add-custom-group.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}