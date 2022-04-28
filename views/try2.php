<?php 

require dirname(__DIR__) . '/lib/init.php';
$ssc = new SSC;

if(isset($_POST['import_file_hidden'])){
	$file = $_FILES['file'];
	$json = [];

	$json['message'] = "<b>Error!</b> Something went wrong. Please contact the administrator!";
	$json['alert'] = "danger";

	if(!empty($file['name'])){
		if($file['type'] == 'text/plain'){
			$exp = explode('.', $file['name']);
			$type = end($exp);

			if($type == 'txt'){
				print_r($_FILES);
			} else{

			}
			
		} else{
			$json['message'] = "<b>Error!</b> File!";
		}
	} else{
		$json['message'] = "<b>Error!</b> Cannot import empty file!";
	}

	echo json_encode($json);
	
	// $sql = $ssc->importBiometricData($data['tmp_name']);
	// echo json_encode($sql);
}

$sql = $ssc->biometricDateMatches(1, '2019-02-25');
var_dump($sql);