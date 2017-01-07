<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

class PublicPagesController extends Controller {

	public function index()
	{
		self::view("public-pages/index.inc");
	}

	public function Login()
	{
		$data = array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		);
		self::view("public-pages/login.inc", $data);
	}
}
