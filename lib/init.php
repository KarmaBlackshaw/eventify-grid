<?php

session_start();

date_default_timezone_set('Asia/Manila');

require_once dirname(__DIR__) . '/lib/config.php';
require_once dirname(__DIR__) . '/lib/helpers.php';
vendor('autoload');
library('errors');
library('database');
library('settings');

$init = new Database;
