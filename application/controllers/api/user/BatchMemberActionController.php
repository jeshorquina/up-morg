<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Http;
use \Jesh\Helpers\PermissionHelper;

use \Jesh\Operations\User\BatchMemberActionOperations;

class BatchMemberActionController extends Controller 
{
    private $operations;

    public function __construct()
    {
        parent::__construct();

        if(PermissionHelper::HasUserPageAccess(self::GetBaseURL(), true)) 
        {
            $this->operations = new BatchMemberActionOperations;
        }
    }

}
