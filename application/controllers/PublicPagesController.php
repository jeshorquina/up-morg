<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Controllers\Controller;

class PublicPagesController extends Controller {

	public function index()
	{
		self::view("public-pages/index.php");
	}
}
