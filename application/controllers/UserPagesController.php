<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Core\Wrappers\Controller;

class UserPagesController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Index()
	{
		self::RenderView("user-pages/index.inc");
	}

}
