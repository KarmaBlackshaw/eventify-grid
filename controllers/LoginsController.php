<?php

require_once dirname(__DIR__) . '/lib/init.php';
$audit = new Audit;

if(isset($_POST['btn_login'])){
	$username = $init->post('login_username');
	$password = $init->post('login_password');

	$_SESSION['logged_in'] = false;
	$_SESSION['bldg_coordinator_only'] = false;

	if(!validate([$username, $password])){
		header('Location: ' . base_views('index.php?e=1'));
		exit();
	} else{

		$check_username = "SELECT accounts.user_level_id , user_levels.user_level, accounts.account_id
			FROM accounts 
			JOIN user_levels 
			ON accounts.user_level_id = user_levels.user_level_id 
			WHERE username = '$username'";

		$count = $init->count($check_username);

		if($count > 1){
			header('Location: ' . base_views('index','e=2'));
			exit();
		} elseif($count === 0){
			header('Location: ' . base_views('index', 'e=3'));
			exit();
		} else{

			$sql = $init->getData($check_username);

			$user_level_id = $sql[0]->user_level_id;
			$user_level = $sql[0]->user_level;
			$account_id = $sql[0]->account_id;

			if($user_level_id === '5' || $user_level_id === '6'){
				$query = "SELECT accounts.password, students.student_id, names.fname, names.mname, names.lname, positions.position, positions.position_id
					FROM accounts 
					JOIN students ON accounts.account_id = students.account_id 
					JOIN names ON students.name_id = names.name_id 
					LEFT JOIN ssc ON ssc.students_id = students.students_id
					LEFT JOIN positions ON positions.position_id = ssc.position_id
					WHERE accounts.account_id = '$account_id'";

				$sql = $init->getData($query);

				$student_id = $sql[0]->student_id;

			} else{

				$query = "SELECT accounts.password, employees.employee_id, employees.employees_id, names.fname, names.mname, names.lname, positions.position, positions.position_id, positions.office_id, offices.office, bldg_coordinators.bldg_coordinator_id
				FROM accounts 
				JOIN employees ON employees.account_id = accounts.account_id 
				JOIN names ON employees.name_id = names.name_id 
				JOIN positions ON employees.position_id = positions.position_id 
				JOIN offices ON positions.office_id = offices.office_id
				LEFT JOIN bldg_coordinators ON bldg_coordinators.employees_id = employees.employees_id
				AND bldg_coordinators.removed = 0
				WHERE accounts.account_id = '$account_id'";

				$sql = $init->getData($query);

				$employees_id = $sql[0]->employees_id;
				$office_id = $sql[0]->office_id;
				$office = $sql[0]->office;
				$bldg_coordinator_id = $sql[0]->bldg_coordinator_id;
			}

			$fname = $sql[0]->fname;
			$mname = $sql[0]->mname;
			$lname = $sql[0]->lname;
			$hash = $sql[0]->password;
			$position = $sql[0]->position;
			$position_id = $sql[0]->position_id;

			if(!password_verify($password, $hash)){
				header('Location: ' . base_views('index', 'e=4'));
				exit();
			} else{
				$_SESSION['user_level_id'] = $user_level_id;
				$_SESSION['user_level'] = $user_level;
				$_SESSION['employees_id'] = $employees_id;
				$_SESSION['account_id'] = $account_id;
				$_SESSION['full_name'] = formatName($fname, $mname, $lname);
				$_SESSION['position'] = $position;
				$_SESSION['position_id'] = $position_id;
				$_SESSION['logged_in'] = true;
				
				if($user_level_id === '5'){ // Student
					header('Location: ' . base_views('student/index'));
					exit();

				} elseif($user_level_id === '6'){ // ssc
						// $_SESSION['user_level_id'] = $user_level_id;
						// session_write_close(); 
						header('Location: ' . base_views('ssc/index'));
						die();
				} elseif($user_level_id === '7'){ // Building Coordinator
					header('Location: ' . base_views('bldg_coordinator/index'));
					exit();

				} elseif($user_level_id === '2'){ //  Administration
					$_SESSION['office_id'] = $office_id;
					$_SESSION['office'] = $office;
					$_SESSION['bldg_coordinator_id'] = $bldg_coordinator_id;

					switch ($office_id) {
						case '11': // Management Information System
							header('Location: ' . base_views('mis/index'));
							exit();
							break;

						case '12': // Plant and Facilities
							header('Location: ' . base_views('plant_and_facilities/index'));
							exit();
							break;

						case '6': // Office of Student Affairs
							header('Location: ' . base_views('student_affairs/index'));
							exit();
							break;

						case '13': // Supreme Student Council Administration
							header('Location: ' . base_views('adviser/index'));
							exit();
							break;
						
						default: // No user interface yet
							// echo $_SESSION['bldg_coordinator_id'];
							if($_SESSION['bldg_coordinator_id'] != NULL){
								$_SESSION['bldg_coordinator_only'] = true;
								header('Location: ' . base_views('bldg_coordinator/index'));
								exit();
							} else{
								header('Location: ' . base_views('error/user_unidentified'));
								session_destroy();
								exit();
							}
							break;
					}
				} else{
					session_destroy();
					header('Location: ' . base_views('index', 'e=6'));
					exit();
				}
			}
		}
	}
}

if(isset($_POST['navbar_name'])){
}

if(isset($_POST['logout'])){
	unset($_SESSION['user_level_id']);
	unset($_SESSION['user_level']);
	unset($_SESSION['account_id']);
	unset($_SESSION['full_name']);
	unset($_SESSION['position']);
	unset($_SESSION['logged_in']);
	unset($_SESSION['office_id']);
	unset($_SESSION['office']);
	unset($_SESSION['employees_id']);
	unset($_SESSION['bldg_coordinator_id']);
	session_destroy();
}