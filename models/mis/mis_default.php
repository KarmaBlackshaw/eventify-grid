<?php  

if($_SESSION['user_level_id'] !== '2'){
	$_SESSION['logged_in'] = false;
}

if($_SESSION['office_id'] !== '11'){
	$_SESSION['logged_in'] = false;
}