<?php
namespace Jesh\Operations;

use \Jesh\Helpers\Security;
use \Jesh\Helpers\Session;
use \Jesh\Helpers\ValidationDataBuilder;

use \Jesh\Models\MemberModel;
use \Jesh\Repository\UserActionOperationsRepository;

class UserActionOperations
{
    private $repository;

    public function __construct()
    {
        $this->repository = new UserActionOperationsRepository;
    }
}
