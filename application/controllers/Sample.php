<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Jesh\Controllers\Controller;
use \Jesh\Operations\SampleOperations;

class Sample extends Controller {

	public function index()
	{
		(new SampleOperations)->CreateBatch();
		self::view("welcome_message");
	}
}
