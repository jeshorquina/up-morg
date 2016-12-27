<?php
class Welcome extends \Jesh\Controllers\Controller {

	public function index()
	{
		(New \Jesh\Operations\SampleOperations)->CreateBatch();
	}
}
