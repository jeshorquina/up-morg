<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;
use \Jesh\Operations\UserActionOperations;

class UserActionController extends Controller {

    private static $operations;

    public function __construct()
    {
        parent::__construct();
        self::$operations = new UserActionOperations;
    }

	public function Login()
	{
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        if(self::$operations->ExistingUsername($username))
        {
            if(self::$operations->MatchingPassword($username, $password))
            {
                echo "Hello";
            }
        }
	}
    
}
