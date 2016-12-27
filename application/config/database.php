<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$database_helper = new Jesh\Core\DatabaseHelper(FCPATH.'config.yml');
try
{
	$active_group 	= $database_helper->getDefaultActiveGroup();
	$query_builder 	= $database_helper->isQueryBuilderEnabled();
	$db 			= $database_helper->buildGroups();
}
catch(Exception $e) 
{
	printf("Unable to prepare database configuration: %s", $e->getMessage());
}
