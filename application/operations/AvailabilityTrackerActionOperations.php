<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Repository\AvailabilityTrackerActionOperationsRepository;

use \Jesh\Models\AvailabilityMemberModel;

class AvailabilityTrackerActionOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AvailabilityTrackerActionOperationsRepository;
    }

    public function UpdateSchedule(AvailabilityMembermodel $availability)
    {
        return $this->repository->UpdateSchedule($availability);
    }
}
