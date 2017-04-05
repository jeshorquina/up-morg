<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\Security;

class AvailabilityTrackerActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = self::InitializeOperations("AvailabilityTrackerActionOperations");
    }

    public function UpdateSchedule()
    {

    }

    public function DeleteGroup()
    {

    }

    public function CreateNewGroup()
    {
        
    }
}