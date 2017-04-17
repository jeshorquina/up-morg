<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;

use \Jesh\Operations\User\TaskActionOperations;

class TaskManagerActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess("task"))
        {
            $this->operations = new TaskActionOperations;
        }
    }
}
