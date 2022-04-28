
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<?php
require dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$ssc = new SSC;
$adviser = new Adviser;

// $sql = $init->query("UPDATE positions SET removed = 0 WHERE position_id = 1");
$sql = $init->query("DELETE FROM positions ORDER BY position_id DESC LIMIT 1");

echo json_encode($sql);

// $rest = '+639264566783';    // returns "f"
// echo formatPhoneNumber($rest);

