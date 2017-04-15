<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;

class TaskManagerPageController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function TaskManager()
    {
        self::SetBody("user/task-manager.html.inc");
        self::RenderView(Security::GetCSRFData());
    }

    public function FullTask()
    {
        self::SetBody("user/subdirectory/task.html.inc");
        self::RenderView(Security::GetCSRFData());
    }
}