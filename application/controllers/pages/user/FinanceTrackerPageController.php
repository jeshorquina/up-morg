<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class FinanceTrackerPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function FinanceTracker()
    {
        self::SetBody("user/finance-tracker.html.inc");
        self::RenderView(Security::GetCSRFData());
    }

    public function GenerateStatement()
    {
        self::SetBody("user/subdirectory/financial-statement.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}