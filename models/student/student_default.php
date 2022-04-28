<?php

if($_SESSION['user_level_id'] !== '5'){
	$_SESSION['logged_in'] = false;
}