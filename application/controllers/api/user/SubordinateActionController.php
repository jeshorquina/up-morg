<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PageRenderer;

use \Jesh\Operations\User\SubordinateActionOperations;

class SubordinateActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PageRenderer::HasUserPageAccess(self::GetBaseURL(), "subordinate")) 
        {
            $this->operations = new SubordinateActionOperations;
        }
    }
}
