<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

class IndexController extends Controller 
{
    public function index()
    {
        self::Redirect("login");
    }
}
