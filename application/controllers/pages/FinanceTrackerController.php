<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class FinanceTrackerController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GenerateStatement()
    {
        self::SetBody("user-pages/minor-pages/financial-statement.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}