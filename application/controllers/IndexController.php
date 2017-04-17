<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

use \Jesh\Helpers\Url;

class IndexController extends Controller 
{
    public function index()
    {
        Url::Redirect("login");
    }

    public function UserHomepage()
    {
        Url::Redirect("task");
    }
}
