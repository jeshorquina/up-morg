<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Repository\AvailabilityTrackerActionOperationsRepository;

use \Jesh\Models\TaskModel;

class AvailabilityTrackerActionOperations
{
    public function __construct()
    {
        $this->repository = new AvailabilityTrackerActionOperationsRepository;
    }
}