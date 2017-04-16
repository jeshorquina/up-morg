<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\PermissionHelper;

class IndexController extends Controller 
{
    public function index()
    {
        self::Redirect("login");
    }

    public function UserHomepage()
    {
        self::Redirect("task");
    }
}
