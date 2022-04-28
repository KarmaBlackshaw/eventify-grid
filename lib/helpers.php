
<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

// Absolutes
function base_url($file = ''){
	return base . $file;
}

function base_assets($file = ""){
	// return base . 'assets/' . $file;
	$explode = array_slice(explode(ds, root), 3);
	// return '/' . $explode[0] . '/assets/' . $file;
	return '/assets/' . $file;
}

function base_views($file = "", $get = ""){
	if($file != '' && $get == ''){
		// return base . 'views/' . $file . ".php";
		return '/views/' . $file . ".php";
		die();
	}

	if($file == '' && $get == ''){
		// return base . 'views/';
		return '/views/';
		die();
	}

	// return base . 'views/' . $file . ".php?" . $get;
	return '/views/' . $file . ".php?" . $get;
}

function base_controllers($file, $get = ""){
	if($get === ""){
		// return base . 'controllers/' . $file . ".php";
		return '/controllers/' . $file . ".php";
	}
		// return base . 'controllers/' . $file . ".php";
	return '/controllers/' . $file . ".php?" . $get;
}

function root($file){
	if(!file_exists(root . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once root . $file . '.php';
}

function node($file = ""){
	// return base . 'node_modules/' . $file;
	return '/node_modules/' . $file;
}

function assets($file = false){
		$explode = array_slice(explode(ds, root), 3);
		// return '/' . $explode[0] . '/assets/' . $file;
		return '/assets/' . $file;
}

function library($file){
	if(!file_exists(library . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once library . $file . '.php';
}

function controllers($file){
	if(!file_exists(controllers . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once controllers . $file . '.php';
}

function models($file){
	if(!file_exists(models . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once models . $file . '.php';
}

function views($file){
	if(!file_exists(views . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once views . $file . '.php';
}

function layouts($file){
	if(!file_exists(views . 'layout' . ds . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once views . 'layout' . ds . $file . '.php';
}

function vendor($file){
	if(!file_exists(vendor . $file . '.php')){
		die("$file not found!");
		return false;
	} require_once vendor . $file . '.php';
}

// Pure helpers
function dd($file){
	var_dump($file);
	die();
}

function validate($array){
	$bool = true;
	$empty = [];
	
	foreach($array as $k => $v){
		if(empty($v)){
			$bool = $bool && false;
			array_push($empty, $v);
		} else{
			$bool = $bool && true;
		}
	}
	return $bool;
}

function check_err($arr){
	$error = [];
	$str = "";

	foreach($arr as $data => $i){
		if(empty($i)){
			$explode = explode('_', $data);

			foreach($explode as $var){
				$str .= ucfirst($var) . " ";
			}

			$error[] = "<b>$str</b> is required!";
			$str = "";
		}
	}

	return $error;
}

function acronym($var){
	$temp = preg_replace('/\b(\w)|./', '$1', $var);
	return preg_replace("/(?![A-Z])./", "", $temp);
}

function encrypt($password){
	return password_hash($password, CRYPT_BLOWFISH);
}

function ordinal($num){
  $first_word = array('eth','First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth','Ninth','Tenth','Elevents','Twelfth','Thirteenth','Fourteenth','Fifteenth','Sixteenth','Seventeenth','Eighteenth','Nineteenth','Twentieth');
  $second_word =array('','','Twenty','Thirty','Forty','Fifty');

  if($num <= 20)
    return $first_word[$num];

  $first_num = substr($num,-1,1);
  $second_num = substr($num,-2,1);

  return $string = str_replace('y-eth','ieth',$second_word[$second_num].'-'.$first_word[$first_num]);
}
// SMS
function sms($ip, $number, $message){
	$count = count($number);
	$smsIp = "http://". $ip ."/";
	$bool = true;

	for($i = 0; $i < $count; $i++){
		$each_num = $number[$i];

		$data = json_encode(array("number" => $each_num, "text" => $message));

		$ch = curl_init($smsIp);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($result, true);

		if($result){
			$bool && true;
		} else{
			$bool && false;
		}
		
		sleep(3);
	}

	return (bool)$bool;
}

function server_addr(){
	$host = gethostname();
	return $ip = gethostbyname($host);
}

function execution_time(){
	return microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
}

function get_months(){
	$months = [];

	for($i = 1; $i <= 12; $i++){
		$months[] = Carbon::createFromFormat('m', $i)->format('F');
	}

	return $months;
}

function formatName($fname, $mname, $lname, $format = 'FML'){
	$acronym = acronym($mname);

	if($acronym == ''){
		return "$fname $lname";
	}

	if($format == 'FML'){
		return "$fname $acronym. $lname";
	}

	if($format == 'LFM'){
		return "$lname $fname, $acronym";
	}
}

function formatDate($first_date, $end_date){
	if($first_date->isSameMonth($end_date)){
	    if($first_date->isSameDay($end_date)){
	        return $first_date->toFormattedDateString();
	    } else{
	        $first_day = $first_date->day;
	        $last_day = $end_date->day;

	        return "$first_date->shortEnglishMonth $first_day-$last_day, $first_date->year";
	    }
	} else{
	    return $first_date->toFormattedDateString() . "-" . $end_date->toFormattedDateString();
	}
}

function formatTime($time){
	$data = explode('%', $time);

	if(!empty($data)){
		return $data[0] . ' - ' . end($data);
	}
}

function inSqlString($arr){
	if(is_array($arr)){
		if(!empty($arr)){
			return "'" . implode("','", array_map('trim', $arr)) . "'";
		} else{
			return "''";
		}
		
	}
	return;
}

function formatPhoneNumber($number){
	if($number[0] != '+'){
		$new = "+63";
		$new .= substr($number, 1);
		return "'" . $new . "'";
	}

	return "'" . $number . "'";
}