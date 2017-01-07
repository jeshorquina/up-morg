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

        if(!self::$operations->ExistingUsername($username))
        {
            return -1;
        }

        if(!self::$operations->MatchingPassword($username, $password))
        {
            return -1;
        }

        return 0;
	}

    public function Signup()
    {
        $first_name         = $this->input->post("first_name");
        $middle_name        = $this->input->post("middle_name");
        $last_name          = $this->input->post("last_name");
        $email              = $this->input->post("email");
        $phone              = $this->input->post("phone");
        $first_password     = $this->input->post("first_password");
        $second_password    = $this->input->post("second_password");

        if(!self::$operations->IsRegistrationDataValid($first_name, $middle_name, 
                                                        $last_name, $email, $phone, 
                                                        $first_password, $second_password))
        {
            return -1;
        }

        echo "tralala";
    }
}
