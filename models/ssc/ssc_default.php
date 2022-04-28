<?php  

if(isset($_SESSION['user_level_id'])){
	if($_SESSION['user_level_id'] != '6'){
		$_SESSION['logged_in'] = false;
      	header('Location: ' . base_views('error/session_error'));
	}
} else{
	ob_start();
		error_reporting(0);

			require_once dirname(dirname(__DIR__)) . '/views/error/session_error.php';

		error_reporting(1);
	ob_end_flush();
	die();
}
