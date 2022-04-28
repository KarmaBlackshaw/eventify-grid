<?php 

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;


if(isset($_FILES['input_change_profile']) || isset($_FILES['input_change_cover'])){
	$layouts = new Layouts();
	$profile = $_FILES['input_change_profile'];
	$cover = $_FILES['input_change_cover'];
	$date = Carbon::now()->format('Ymdhis');
	$image_url = '';
	$image_src = '';
	$tmp_name = '';

	if(!empty($cover['name'])){
		$name = $cover['name'];
		$type = $cover['type'];
		$tmp_name = $cover['tmp_name'];
		$error = (int) $cover['error'];
		$size = $cover['size'];
		$file_extension = explode('.', $name);

		if($error == 0){
			if(!in_array(end($file_extension), array('jpg','jpeg','png'))){
				header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] .'?error=.' . end($file_extension) . ' file type is not valid');
				exit();
			} else{
				$audit->audit("Updated cover photo");
				$new_name = $date . md5($date . $name) . '.' . end($file_extension);
				$image_url = 'images/covers/' . $new_name;
			}
		} else{
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] .'?error=' . $error);
			exit();
		}
		
	} else{
		$name = $profile['name'];
		$type = $profile['type'];
		$tmp_name = $profile['tmp_name'];
		$error = (int) $profile['error'];
		$size = $profile['size'];
		$file_extension = explode('.', $name);

		if($error == 0){
			if(!in_array(end($file_extension), array('jpg','jpeg','png'))){
				header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] .'?error=' . end($file_extension) . ' file type is not valid');
				exit();
				echo end($file_extension);
			} else{
				$audit->audit("Updated your profile picture");
				$new_name = $date . md5($date . $name) . '.' . end($file_extension);
				$image_url = 'images/profiles/' . $new_name;
			}
		} else{
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] .'?error=' . $error);
			exit();
		}
	}

	$root = $_SERVER['DOCUMENT_ROOT'] . base_assets();
	$image_src = $root . $image_url;
	$move = move_uploaded_file($tmp_name, $image_src);

	if($move){
		if(!empty($cover['name'])){
			$sql = $layouts->changeCover($image_url);
		} else{
			$sql = $layouts->changeProfile($image_url);
		}

		if($sql){
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?success');
			exit();
		} else{
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?error=' . $error);
			exit();
		}
	} else{
		header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?error=' . $error);
		exit();
	}
}

if(isset($_POST['update_profile'])){
	$post = $_POST;
	$layouts = new Layouts();

	$json = array();
	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = 'danger';

	unset($post['facebook_account']);
	unset($post['twitter_account']);
	unset($post['instagram_account']);
	unset($post['about_me']);
	unset($post['update_profile']);

	$fname = $init->post('first_name');
	$mname = $init->post('middle_name');
	$lname = $init->post('last_name');
	$username = $init->post('username');
	$user_contact = $init->post('user_contact');
	$facebook_account = $init->post('facebook_account');
	$twitter_account = $init->post('twitter_account');
	$instagram_account = $init->post('instagram_account');
	$about_me = $init->post('about_me');

	$validate = check_err($post);

	if(empty(count($validate))){
		if($layouts->isMyUsername($username)){
			if($layouts->isStudent()){
				$sql = $init->query("
					UPDATE accounts a 
					JOIN students s ON s.account_id = a.account_id
					JOIN names n ON n.name_id = s.name_id
					JOIN contacts c ON c.contact_id = s.contact_id
					SET n.fname = '$fname', n.mname = '$mname', n.lname = '$lname', a.username = '$username', c.user_contact = '$user_contact', a.facebook_account = '$facebook_account', a.twitter_account = '$twitter_account', a.instagram_account = '$instagram_account', a.about_me = '$about_me'
					WHERE a.account_id = {$_SESSION['account_id']}
				");
			} else{
				$sql = $init->query("
					UPDATE accounts a 
					JOIN employees e ON e.account_id = a.account_id
					JOIN names n ON n.name_id = e.name_id
					JOIN contacts c ON c.contact_id = e.contact_id
					SET n.fname = '$fname', n.mname = '$mname', n.lname = '$lname', a.username = '$username', c.user_contact = '$user_contact', a.facebook_account = '$facebook_account', a.twitter_account = '$twitter_account', a.instagram_account = '$instagram_account', a.about_me = '$about_me'
					WHERE a.account_id = {$_SESSION['account_id']}
				");
			}
		} else{
			if($layouts->usernameExists($username)){
				header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?error=Username is already taken');
				exit();
			} else{
				if($layouts->isStudent()){
					$sql = $init->query("
						UPDATE accounts a 
						JOIN students s ON s.account_id = a.account_id
						JOIN names n ON n.name_id = s.name_id
						JOIN contacts c ON c.contact_id = s.contact_id
						SET n.fname = '$fname', n.mname = '$mname', n.lname = '$lname', a.username = '$username', c.user_contact = '$user_contact', a.facebook_account = '$facebook_account', a.twitter_account = '$twitter_account', a.instagram_account = '$instagram_account', a.about_me = '$about_me'
						WHERE a.account_id = {$_SESSION['account_id']}
					");
				} else{
					$sql = $init->query("
						UPDATE accounts a 
						JOIN employees e ON e.account_id = a.account_id
						JOIN names n ON n.name_id = e.name_id
						JOIN contacts c ON c.contact_id = e.contact_id
						SET n.fname = '$fname', n.mname = '$mname', n.lname = '$lname', a.username = '$username', c.user_contact = '$user_contact', a.facebook_account = '$facebook_account', a.twitter_account = '$twitter_account', a.instagram_account = '$instagram_account', a.about_me = '$about_me'
						WHERE a.account_id = {$_SESSION['account_id']}
					");
				}
			}
		}

		if($sql){
			$audit->audit("Updated profile");
			$_SESSION['full_name'] = formatName($fname, $mname, $lname);
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?success');
			exit();
		} else{
			header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?error=' . $init->error());
			exit();
		}
	} else{
		header('Location: ' . explode('?', $_SERVER['HTTP_REFERER'])[0] . '?error=Fields cannot be left empty');
		exit();
	}
}