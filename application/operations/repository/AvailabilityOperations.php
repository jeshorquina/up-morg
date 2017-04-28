<?php
namespace Jesh\Operations\Repository;

use \Jesh\Models\AvailabilityMemberModel;

use \Jesh\Repository\AvailabilityOperationsRepository;

class AvailabilityOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new AvailabilityOperationsRepository;
    }

    public function GetAvailability($batch_member_id)
    {
        $availability = $this->repository->GetAvailability($batch_member_id);
        if(sizeof($availability) === 1)
        {
            return new AvailabilityMemberModel($availability[0]);
        }
        else 
        {
            throw new \Exception(
                sprintf(
                    "No availability record for batch member id = %s found",
                    $batch_member_id
                )
            );
        }
    }
}
