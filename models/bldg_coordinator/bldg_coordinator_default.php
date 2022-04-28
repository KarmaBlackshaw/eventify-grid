<?php

if(!isset($_SESSION['bldg_coordinator_id'])){
	ob_start();
		error_reporting(0);

			require_once dirname(dirname(__DIR__)) . '/views/error/session_error.php';

		error_reporting(1);
	ob_end_flush();
	die();
}