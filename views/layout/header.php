<?php  

require_once dirname(dirname(__DIR__)) . '/lib/init.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

	<title>LNU - SEMMS</title>

    <link rel="icon" href="<?= assets('images/website_icon.ico') ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

	<!-- css -->

    <link rel="stylesheet" type="text/css" href="<?= assets('css/animate.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/font_awesome.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/hover-min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets('css/bootstrapv4.3.1.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/style.css') ?>">

	<!-- fonts -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext"> -->

	<!-- dashboard -->
	<link rel="stylesheet" type="text/css" href="<?= assets('dashboard/css/dashboard.css') ?>">

    <!-- Javascripts -->
    <script type="text/javascript" src="<?= assets('js/bootstrap.slim.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('js/popper-bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('js/jquery.min.js') ?>"></script>
    <script src="<?= assets('dataTables/dataTables.min.js') ?>"></script>
    <script src="<?= assets('dataTables/dataTables.bootstrap.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= assets('dataTables/dataTables.bootstrap.min.css') ?>">

</head>
<body>