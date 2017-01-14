<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

class PublicPagesController extends Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		self::RenderView("public-pages/index.inc");
	}

	public function Login()
	{
		$data = array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		);
		self::RenderView("public-pages/login.inc", $data);
	}

	public function Signup()
	{
		$data = array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		);
		self::RenderView("public-pages/signup.inc", $data);
	}
}
