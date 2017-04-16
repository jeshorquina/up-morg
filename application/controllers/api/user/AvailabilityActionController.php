<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;

use \Jesh\Operations\User\AvailabilityActionOperations;

class AvailabilityActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        $this->operations = new AvailabilityActionOperations;
    }
}