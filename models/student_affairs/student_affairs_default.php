<?php  

if($_SESSION['user_level_id'] !== '2' || $_SESSION['office_id'] !== '6'){
	ob_start();
		error_reporting(0);

			require_once dirname(dirname(__DIR__)) . '/views/error/session_error.php';

		error_reporting(1);
	ob_end_flush();
	die();
}