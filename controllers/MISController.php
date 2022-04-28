<?php

require_once dirname(__DIR__) . '/lib/init.php';
$audit = new Audit;
$mis = new MIS;

// Students Add
if(isset($_POST['load_student_departments'])){
	$sql = $init->getData("SELECT department_id, department FROM departments WHERE removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->options = '
		<div class="btn-group">
			<button class="btn btn-primary btn-sm call_modal_edit_department" data-id="'. $sql[$i]->department_id .'" data-dep="'. $sql[$i]->department .'">Edit</button>
			<button class="btn btn-warning btn-sm call_modal_remove_department" data-id="'. $sql[$i]->department_id .'" data-dep="'. $sql[$i]->department .'">Remove</button>
		</div>
		';
	}

	echo json_encode($sql);
}

if(isset($_POST['load_student_courses'])){
	$department_id = $init->post('load_student_courses');

	$sql = $init->getData("SELECT course_id, course FROM courses WHERE department_id = '$department_id' AND removed = 0");

	echo json_encode($sql);
}

if(isset($_POST['load_student_sections'])){
	$course_id = $init->post('course_id');
	$year_level = $init->post('year_level');

	$sql = $init->getData("SELECT section_id, section FROM sections WHERE course_id = '$course_id' AND year_level = '$year_level' AND removed = 0");

	echo json_encode($sql);
}

if(isset($_POST['add_student'])){
	$fname = $init->post('fname');
	$mname = $init->post('mname');
	$lname = $init->post('lname');
	$fullname = formatName($fname, $mname, $lname);
	$user_contact = $init->post('user_contact');
	$emergency_contact = $init->post('emergency_contact');
	$gender = $init->post('gender');
	$department_id = $init->post('department_id');
	$course_id = $init->post('course_id');
	$year_level = $init->post('year_level');
	$section_id = $init->post('section_id');
	$student_id = $init->post('student_id');
	$sms_address = $init->post('sms_address');
	$title = ($gender == 'M') ? 'Mr.' : 'Ms.';

	$image_url = ($gender == 'M') ? 'images/male.png' : 'images/female.png';
	$activation_code = strtoupper(substr(md5(date('F d, Y H:i:s A')), 0, 10));

	$json = array();

	if(!validate([$fname, $mname, $lname, $user_contact, $gender, $department_id, $course_id, $year_level, $section_id, $student_id, $sms_address])){
		$json['bool'] = false;
		$json['message'] = '<b><i class="fas fa-exclamation-triangle mr-1"></i> Error!</b> All fields are required!';
		$json['alert'] = 'alert-danger';
		$json['notify'] = 'danger';
	} else{
		$count = $init->count("SELECT student_id FROM students WHERE student_id = '$student_id'");

		if($count === 1){
			$json['bool'] = false;
			$json['message'] = "<b><i class='fas fa-exclamation-triangle mr-1'></i> Error!</b> Student $student_id! is already registered!";
			$json['alert'] = 'alert-danger';
			$json['notify'] = 'danger';
		} else{
			$names_sql = $init->query("INSERT INTO names(fname, mname, lname) VALUES('$fname', '$mname', '$lname')");
			$name_id = $init->insert_id();

			$contacts_sql = $init->query("INSERT INTO contacts(user_contact, emergency_contact) VALUES('$user_contact', '$emergency_contact')");
			$contact_id = $init->insert_id();

			$accounts_sql = $init->query("INSERT INTO accounts(user_level_id, activation_code, account_img_url) VALUES('5', '$activation_code', '$image_url')");
			$account_id = $init->insert_id();

			$students_sql = $init->query("INSERT INTO students(student_id, name_id, section_id, contact_id, account_id, gender) VALUES('$student_id', '$name_id', '$section_id', '$contact_id', '$account_id', '$gender')");

			if($students_sql){
				$sms = SSC::sms(formatPhoneNumber($user_contact), "Good day $title $fullname, your activation code is $activation_code.");

				if($sms){
					$audit->audit("Registered a new student to the database");
					$json['bool'] = true;
					$json['message'] = "Successfully added the student to the database!";
					$json['alert'] = "alert-success";
					$json['notify'] = 'success';
					$json['activation_code'] = $activation_code;
				} else{
					$json['bool'] = true;
					$json['message'] = "<b>Warning!</b> The student was successfully added to the database but something went wrong with the SMS! Please contact the administrator";
					$json['alert'] = "alert-warning";
					$json['notify'] = 'success';
					$json['activation_code'] = $activation_code;
				}
			} else{
				$json['bool'] = false;
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrators";
				$json['alert'] = "alert-danger";
				$json['notify'] = 'success';
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['register_student'])){
	$student_id = $init->post('student_id');
	$fname = $init->post('first_name');
	$mname = $init->post('middle_name');
	$lname = $init->post('last_name');
	$gender = $init->post('gender');
	$contact = $init->post('contact');
	$department_id = $init->post('department');
	$year_level = $init->post('year_level');

	$image_url = ($gender == 'M') ? 'images/male.png' : 'images/female.png';
	$activation_code = strtoupper(substr(md5(date('F d, Y H:i:s A')), 0, 10));

	$json['alert'] = 'danger';
	$json['message'] = '<b>Error!</b> Something went wrong! Please contact the administrator!';

	$validate = check_err($_POST);

	if(empty($validate)){
		if($mis->studentExists($student_id)){
			$json['message'] = "<b>Error!</b> Student ID is already registered in the database!";
		} else{
			$name_id = $mis->insertName($fname, $mname, $lname);
			$contact_id = $mis->insertContact($contact);
			$account_id = $mis->insertAccount(5, $activation_code, $image_url);

			$sql = $init->query("INSERT INTO students(student_id, name_id, contact_id, department_id, year_level, account_id, gender) VALUES('$student_id', '$name_id', '$contact_id', '$department_id', '$year_level', '$account_id', '$gender')");

			if($sql){
				// $sms = sms($sms_address, [$user_contact], "Good day $title $fname $lname, your activation code is $activation_code.");
				$audit->audit("Registered a new student to the database");
				$json['message'] = "Successfully added the student to the database!";
				$json['alert'] = 'success';
				$json['activation_code'] = $activation_code;
			}
		}
	} else{
		$json['message'] = $validate;
	}

	echo json_encode($json);
}

// Students Student
if(isset($_POST['load_table_students_student'])){
	$sql = $mis->getStudents();

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->img_src = '<img src="'. assets($sql[$i]->account_img_url) .'" alt="" class="avatar mr-3 align-self-center">';
		$sql[$i]->genders = ($sql[$i]->gender == 'M') ? 'Male' : 'Female';
		$sql[$i]->status = ($sql[$i]->activated == 0) ? '<span class="w-100 hvr-grow badge badge-warning">Inactive</span>' : '<span class="w-100 hvr-grow badge badge-success">Activated</span>';
		$sql[$i]->name = '<a href="javascript:" class="d-block text-dark student_name">'. formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname) .'</a><small class="font-weight-light font-italic text-muted font-07">'. $sql[$i]->student_id .'</small>';
		$sql[$i]->departments = $sql[$i]->department;
		$sql[$i]->year_level = ordinal($sql[$i]->year_level) . ' Year';
		$sql[$i]->students_id = '<small class="font-italic font-weight-light text-muted">'. $sql[$i]->student_id .'</small>';
		$sql[$i]->options = '
			<div class="item-action dropdown">
				<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="javascript:void(0)" data-student_id="'. $sql[$i]->student_id .'" class="dropdown-item call_modal_students_student_view_student"><i class="dropdown-icon fe fe-eye mr-1"></i>Edit</a>
					<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-slash mr-1"></i>Disable</a>
				</div>
			</div>
		';
	}

	echo json_encode($sql);
}

if(isset($_POST['load_students_student_modal_information'])){
	$student_id = $init->post('load_students_student_modal_information');

	$sql = $mis->getStudents($student_id);
	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->img_src = assets($sql[$i]->account_img_url);
		$sql[$i]->ordinal_year = ordinal($sql[$i]->year_level) . ' Year';
		$sql[$i]->name = formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname);
		$sql[$i]->account_cover_photo = assets($sql[$i]->account_cover_photo);

		unset($sql[$i]->about_me);
		unset($sql[$i]->account_id);
		unset($sql[$i]->activated);
		unset($sql[$i]->contact_id);
		unset($sql[$i]->created_at);
		unset($sql[$i]->facebook_account);
		unset($sql[$i]->instagram_account);
		unset($sql[$i]->name_id);
		unset($sql[$i]->password);
		unset($sql[$i]->removed);
		unset($sql[$i]->section_id);
		unset($sql[$i]->students_id);
		unset($sql[$i]->twitter_account);
		unset($sql[$i]->updated_at);
		unset($sql[$i]->user_level_id);
		unset($sql[$i]->fname);
		unset($sql[$i]->mname);
		unset($sql[$i]->lname);
		unset($sql[$i]->account_img_url);
		unset($sql[$i]->gender);
	}

	echo json_encode($sql);
}


if(isset($_POST['update_student'])){
	$student_id = $init->post('update_student');
	$department_id = $init->post('college');
	$year_level = $init->post('year_level');

	$json['alert'] = 'danger';
	$json['message'] = '<b>Error!</b> Something went wrong! Please contact the administrator';

	$validate = check_err($_POST);

	if(empty($validate)){
		$sql = $init->query("UPDATE students SET department_id = '$department_id', year_level = '$year_level' WHERE student_id = '$student_id'");

		if($sql){
			$audit->audit("Updated student $student_id's academic profile");
			$json['alert'] = 'success';
			$json['message'] = 'Successfully updated the student!';
		}
	} else{
		$json['message'] = $validate;
	}

	echo json_encode($json);
}

// Programs

if(isset($_POST['edit_department'])){
	$department_id = $init->post('edit_department');
	$department = $init->post('department');

	if(!validate([$department])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty field!";
	} else{
		$count = $init->count("SELECT * FROM departments WHERE department = '$department'");

		if($count > 0){
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> $department already exists in the database!";
		} else{
			$sql = $init->query("UPDATE departments SET department = '$department' WHERE department_id = '$department_id'");

			if($sql){
				$audit->audit("Updated a department");
				$json['bool'] = true;
				$json['alert'] = 'success';
				$json['message'] = "Successfully updated department!";
			} else{
				$json['bool'] = false;
				$json['alert'] = 'danger';
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['remove_department'])){
	$department_id = $init->post('remove_department');

	$json['bool'] = false;
	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	$sql = $init->query("UPDATE departments SET removed = 1 WHERE department_id = '$department_id'");

	if($sql){
		$audit->audit("Removed a department");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully updated department!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['add_department'])){
	$department = $init->post('add_department');

	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	$validate = check_err($_POST);

	if(empty($validate)){
		$sql = $init->query("INSERT INTO departments(department) VALUES('$department')");

		if($sql){
			$audit->audit("Added a new department");
			$json['alert'] = 'success';
			$json['message'] = "Successfully updated department!";
		}
	} else{
		$message = $validate;
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Employees
if(isset($_POST['load_table_employees_manage'])){
	$sql = $init->getData("SELECT accounts.activated, employees.employee_id, names.fname, names.mname, names.lname, offices.office_id, offices.office, positions.position, employees.gender, accounts.account_img_url
		FROM employees 
		JOIN positions ON positions.position_id = employees.position_id
		JOIN offices ON offices.office_id = positions.office_id
		JOIN accounts ON accounts.account_id = employees.account_id
		JOIN names ON names.name_id = employees.name_id
		WHERE accounts.removed = 0 
		AND accounts.account_id <> {$_SESSION['account_id']}");

	$count = count($sql);

	if($count !== '0'){
		for($i = 0; $i < $count; $i++){
			$title = ($sql[$i]->gender == 'M') ? 'Mr.' : 'Ms.';
			$sql[$i]->img_src = '<img src="'. assets($sql[$i]->account_img_url) .'" alt="" class="avatar mr-3 align-self-center">';
			$sql[$i]->name = '<a href="javascript:" class="d-block text-dark student_name">'. formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname) .'</a><small class="font-weight-light font-italic text-muted font-07">'. $sql[$i]->employee_id .'</small>';
			$sql[$i]->status = ($sql[$i]->activated === '0') ? '<span class="w-100 hvr-grow badge badge-warning">Inactive</span>' : '<span class="w-100 hvr-grow badge badge-success">Activated</span>';
			$sql[$i]->options = '
				<div class="item-action dropdown">
					<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="javascript:void(0)" class="dropdown-item table_employees_edit" data-target="'. $sql[$i]->employee_id .'"><i class="dropdown-icon fe fe-eye mr-1"></i>Edit</a>
						<a href="javascript:void(0)" class="dropdown-item table_employees_disable" data-target="'. $sql[$i]->employee_id .'" data-employee="'. $title . ' ' . $sql[$i]->lname .'"><i class="dropdown-icon fe fe-slash mr-1"></i>Disable</a>
					</div>
				</div>
			';
			$sql[$i]->offices = '<span class="small font-italic">'. $sql[$i]->office .'</span>';
		}
	}

	echo json_encode($sql);
}

if(isset($_POST['load_modal_employees_edit'])){
	$employee_id = $init->post('load_modal_employees_edit');

	$sql = $init->getData("SELECT names.fname, names.mname, names.lname, offices.office, offices.office_id, positions.position, positions.position_id, contacts.user_contact, contacts.emergency_contact, accounts.activation_code, accounts.account_img_url
		FROM employees 
		JOIN names ON names.name_id = employees.name_id 
		JOIN positions ON positions.position_id = employees.position_id 
		JOIN offices ON offices.office_id = positions.office_id 
		JOIN contacts ON contacts.contact_id = employees.contact_id 
		JOIN accounts ON accounts.account_id = employees.account_id 
		WHERE employees.employee_id = '$employee_id'");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->img_src = assets($sql[$i]->account_img_url);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_modal_employees_disable'])){
	$employee_id = $init->post('load_modal_employees_disable');

	$sql = $init->query("UPDATE accounts JOIN employees ON employees.account_id = accounts.account_id SET accounts.removed = '1' WHERE employees.employee_id = '$employee_id'");

	if($sql){
		$audit->audit("Disabled an account of an employee");	
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully disabled employee!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['load_modal_employees'])){

	$sql = $init->getData("SELECT office_id, office FROM offices WHERE removed = 0");

	echo json_encode($sql);
}

// Employee
if(isset($_POST['load_modal_employees_position'])){
	$office_id = $init->post('load_modal_employees_position');

	$sql = $init->getData("SELECT position_id, position FROM positions WHERE office_id = '$office_id' AND removed = 0 AND position_id NOT IN (SELECT position_id FROM employees JOIN accounts ON employees.account_id = accounts.account_id WHERE accounts.removed = 0)");

	echo json_encode($sql);
}

if(isset($_POST['modal_manage_employees_edit'])){
	$position_id = (!empty($init->post('modal_manage_employees_edit'))) ? $init->post('modal_manage_employees_edit') : $init->post('hidden_position_id');
	$employee_id = $init->post('employee_id');

	if(!validate([$position_id])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
	} else{
		$sql = $init->query("UPDATE employees SET position_id = '$position_id' WHERE employee_id = '$employee_id'");

		if($sql){
			$audit->audit("Updated an employee's position");
			$json['bool'] = true;
			$json['alert'] = 'success';
			$json['message'] = "Successfully updated employee!";
		} else{
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['load_table_employees_position'])){
	$sql = $init->getData("SELECT positions.position, positions.position_id, offices.office, user_levels.user_level FROM positions 
		JOIN offices ON offices.office_id = positions.office_id 
		JOIN user_levels ON user_levels.user_level_id = positions.user_level_id
		WHERE positions.removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$available = $init->count("SELECT * FROM employees 
			JOIN accounts ON accounts.account_id = employees.account_id 
			WHERE employees.position_id = {$sql[$i]->position_id} AND accounts.removed = 0");

		$sql[$i]->status = ($available > 0) ? '<span class="badge badge-warning">Occupied</span>' : '<span class="badge badge-success">Available</span>';
		$sql[$i]->offices = '<small class="font-italic">'. $sql[$i]->office .'</small>';
		$sql[$i]->options = '
			<div class="item-action dropdown">
				<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="javascript:void(0)" class="dropdown-item table_employees_position_edit" data-target="'. $sql[$i]->position_id .'"><i class="dropdown-icon fe fe-eye mr-1"></i>Edit</a>
					<a href="javascript:void(0)" class="dropdown-item table_employees_position_remove" data-target="'. $sql[$i]->position_id .'" data-position="'. $sql[$i]->position .'" data-office="'. $sql[$i]->office .'"><i class="dropdown-icon fe fe-slash mr-1"></i>Remove</a>
				</div>
			</div>
		';
	}

	echo json_encode($sql);
}

if(isset($_POST['load_modal_position_add_office'])){
	$sql = $init->getData("SELECT office_id, office FROM offices WHERE removed = 0");

	echo json_encode($sql);
}

if(isset($_POST['load_modal_position_add_user_level'])){
	$sql = $init->getData("SELECT user_level_id, user_level FROM user_levels WHERE removed = 0");

	echo json_encode($sql);
}

if(isset($_POST['employees_position_add'])){
	$position = $init->post('employees_position_add');
	$office_id = $init->post('office_id');
	$user_level_id = $init->post('user_level_id');

	if(!validate([$position, $office_id, $user_level_id])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty field!";
	} else{
		$count = $init->count("SELECT * FROM positions WHERE position = '$position' AND office_id = '$office_id' AND user_level_id = '$user_level_id'");

		if($count > 0){
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Position already exists!";
		} else{
			$sql = $init->query("INSERT INTO positions(position, office_id, user_level_id) VALUES('$position', '$office_id', '$user_level_id')");

			if($sql){
				$audit->audit("Registered a new position");
				$json['bool'] = true;
				$json['alert'] = 'success';
				$json['message'] = "Successfully added position to the database!";
			} else{
				$json['bool'] = false;
				$json['alert'] = 'danger';
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['employees_position_edit'])){
	$position_id = $init->post('employees_position_edit');

	$sql = $init->getData("SELECT positions.position, offices.office_id, user_levels.user_level_id FROM positions 
		JOIN offices ON offices.office_id = positions.office_id 
		JOIN user_levels ON user_levels.user_level_id = positions.user_level_id
		WHERE positions.position_id = '$position_id'");

	echo json_encode($sql);
}

if(isset($_POST['modal_employees_position_edit'])){
	$position_id = $init->post('modal_employees_position_edit');
	$position = $init->post('position');
	$office_id = $init->post('office_id');
	$user_level_id = $init->post('user_level_id');

	if(!validate([$position, $office_id, $user_level_id])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
	} else{
		$count = $init->count("SELECT * FROM positions WHERE BINARY position = '$position' AND office_id = '$office_id' AND user_level_id = '$user_level_id'");

		if($count > 0){
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Position already exists in the database!";
		} else{
			$sql = $init->query("UPDATE positions SET position = '$position', office_id = '$office_id', user_level_id = '$user_level_id' WHERE position_id = '$position_id' AND positions.removed = 0");

			if($sql){
				$audit->audit("Updated a position");
				$json['bool'] = true;
				$json['alert'] = 'success';
				$json['message'] = "Successfully updated position!";
			} else{
				$json['bool'] = false;
				$json['alert'] = 'danger';
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['modal_manage_employee_position_remove'])){
	$position_id = $init->post('modal_manage_employee_position_remove');

	$count = $init->count("SELECT * FROM employees 
		JOIN accounts ON accounts.account_id = employees.account_id 
		WHERE employees.position_id = '$position_id' AND accounts.removed = 0");

	if($count > 0){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Position is currently occupied!";
	} else{
		$sql = $init->query("UPDATE positions SET removed = 0");

		if($sql){
			$audit->audit("Removed a position");
			$json['bool'] = true;
			$json['alert'] = 'success';
			$json['message'] = "Successfully removed position!";
		} else{
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['add_employee'])){
	$fname = $init->post('add_employee_fname');
	$mname = $init->post('add_employee_mname');
	$lname = $init->post('add_employee_lname');
	$fullname = formatName($fname, $mname, $lname);
	$user_contact = $init->post('add_employee_user_contact');
	$emergency_contact = $init->post('add_employee_emergency_contact');
	$gender = $init->post('add_employee_gender');
	$employee_id = $init->post('add_employee_id');
	$office_id = $init->post('add_employee_office');
	$position_id = $init->post('add_employee_position');
	$ip_address = $init->post('add_employee_sms_address');
	$signature = $init->post('add_employee_signature');



	$title = ($gender == 'M') ? 'Mr.' : 'Ms.';
	$image_url = ($gender == 'M') ? 'images/male.png' : 'images/female.png';
	$activation_code = strtoupper(substr(md5(date('F d, Y H:i:s A')), 0, 10));
	$json = [];

	if(!validate([$fname, $mname, $lname, $user_contact, $gender, $employee_id, $office_id, $position_id, $signature])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
	} else{
		$filename = $signature . '.txt';
		$dir = assets . '/signatures_temp/' . $filename;
		$signature_txt = file_get_contents($dir);
		$new_dir = assets . 'images/mis/signatures/' . $filename;

		$name_sql = $init->query("INSERT INTO names(fname, mname, lname) VALUES('$fname', '$mname', '$lname')");

		if($name_sql){
			$name_id = $init->insert_id();

			$contact_sql = $init->query("INSERT INTO contacts(user_contact, emergency_contact) VALUES('$user_contact', '$emergency_contact')");

			if($contact_sql){
				$contact_id = $init->insert_id();

				$user_level_sql = $init->getData("SELECT user_levels.user_level_id FROM user_levels JOIN positions ON positions.user_level_id = user_levels.user_level_id WHERE positions.position_id = '$position_id' LIMIT 1");

				$user_level_id = $user_level_sql[0]->user_level_id;

				$account_sql = $init->query("INSERT INTO accounts(user_level_id, activation_code, account_img_url) VALUES('$user_level_id', '$activation_code', '$image_url')");

				if($account_sql){
					$account_id = $init->insert_id();

					$sql = $init->query("INSERT INTO employees(employee_id, name_id, position_id, contact_id, account_id, gender, signature) VALUES('$employee_id', '$name_id', '$position_id', '$contact_id', '$account_id', '$gender', '$signature_txt')");

					if($sql && rename($dir, $new_dir)){
						$sms = SSC::sms(formatPhoneNumber($user_contact), "Good day $title $fullname, your activation code is $activation_code.");

						if($sms){
							$audit->audit("Registered an employee");
							$json['bool'] = true;
							$json['message'] = "Successfully added the employee to the database!";
							$json['alert'] = "alert-success";
							$json['notify'] = 'success';
							$json['activation_code'] = $activation_code;
						} else{
							$json['bool'] = true;
							$json['message'] = "<b>Warning!</b> The employee was successfully added to the database but something went wrong with the SMS! Please contact the administrator";
							$json['alert'] = "alert-warning";
							$json['notify'] = 'success';
							$json['activation_code'] = $activation_code;
						}
					} else{
						$json['bool'] = false;
						$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator";
						$json['alert'] = "alert-danger";
						$json['notify'] = 'success';
					}
				}
			}
		}
	}

	echo json_encode($json);
}

// Office
if(isset($_POST['load_table_employees_office'])){
	$sql = $init->getData("SELECT office_id, office FROM offices WHERE removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->office_id_small = '<small class="font-italic">'. $sql[$i]->office_id .'</small>';
		$sql[$i]->options = '
			<div class="btn-group">
				<button class="btn btn-primary btn-sm employees_office_edit" data-target="'. $sql[$i]->office_id .'" data-office="'. $sql[$i]->office .'">Edit</button>
				<button class="btn btn-warning btn-sm employees_office_remove" data-target="'. $sql[$i]->office_id .'" data-office="'. $sql[$i]->office .'">Remove</button>
			</div>
		';
	}

	echo json_encode($sql);
}

if(isset($_POST['modal_employees_office_edit'])){
	$office_id = $init->post('modal_employees_office_edit');
	$office = $init->post('office');

	if(!validate([$office])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
	} else{
		$count = $init->count("SELECT * FROM offices WHERE office = '$office'");

		if($count > 0){
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Office already exists!";
		} else{
			$sql = $init->query("UPDATE offices SET office = '$office' WHERE office_id = '$office_id'");

			if($sql){
				$audit->audit("Updated an office");
				$json['bool'] = true;
				$json['alert'] = 'success';
				$json['message'] = "Successfully updated office!";
			} else{
				$json['bool'] = false;
				$json['alert'] = 'danger';
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['modal_employees_office_remove'])){
	$office_id = $init->post('modal_employees_office_remove');

	$sql = $init->query("UPDATE offices SET removed = 1 WHERE office_id = '$office_id'");

	if($sql){
		$audit->audit("Removed an office");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully removed office!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['modal_employees_office_add'])){
	$office = $init->post('modal_employees_office_add');

	if(!validate([$office])){
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
	} else{
		$count = $init->count("SELECT * FROM offices WHERE office = '$office'");

		if($count > 0){
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Office already exists!";
		} else{
			$sql = $init->query("INSERT INTO offices(office) VALUES('$office')");

			if($sql){
				$audit->audit("Registered a new office");
				$json['bool'] = true;
				$json['alert'] = 'success';
				$json['message'] = "Successfully added office to the database!";
			} else{
				$json['bool'] = false;
				$json['alert'] = 'danger';
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Signature
if(isset($_POST['save_signature'])){
	$signature = $init->post('save_signature');
	$hash = $init->enc($signature);
	$json['bool'] = false;
	$filename = strtoupper(substr(md5(date('F d, Y H:i:s A')), 0, 10));

	$dir = assets . 'signatures_temp/' . $filename . '.txt';

	if(file_put_contents($dir, $hash)){
		$json['bool'] = true;
		$json['alert'] = 'alert-success';
		$json['message'] = "Filename: $filename";
	} else{
		$json['alert'] = 'alert-danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['signature_dir'])){
	$files = scandir(assets . '/signatures_temp/');
	unset($files[0]);
	unset($files[1]);
	$json = array();

	foreach($files as $data) : ?>
		<?php $filename = assets . 'signatures_temp'. ds . $data; ?>
		<?php $file = explode('.', $data)[0]; ?>

		<li class="list-separated-item">
		  <div class="row align-items-center">
		    <div class="col-auto"> <span class="avatar avatar-md avatar-azure d-block"><i class="fe fe-file-text text-primary"></i></span></div>
		    <div class="col">
		      <div>
		        <a href="javascript:void(0)" class="text-inherit"><?= $file; ?></a>
		      </div>
		      <small class="d-block item-except text-sm text-muted h-1x"><?= date("M d, Y h:i:s A", filemtime($filename)); ?></small>
		    </div>
		    <div class="col-auto"><button class="btn btn-primary btn-sm signate_select_btn" onclick='get_employee_signature("<?= $file ?>")'>Select</button></div>
		  </div>
		</li>

	<?php endforeach;
}

if(isset($_POST['preview_signature'])){
	$filename = $init->post('preview_signature') . '.txt';
	$dir = assets . '/signatures_temp/' . $filename;
	$json = array();
	$json['bool'] = false;

	if(!file_exists($dir)){
		$json['alert'] = 'danger';
		$json['message'] = "Sorry! The file no longer exists!";
	} else{
		$json['bool'] = true;
		$txt = file_get_contents($dir);
		$json['signature'] = $init->dec($txt);
		$json['signature_name'] = "(" . $init->post('preview_signature') . ")";
	}

	echo json_encode($json);
}

// Bldg Coordinator
if(isset($_POST['load_bldg_coordinators'])){
	$sql = $init->getData("SELECT b.bldg_coordinator_id, e.employee_id, e.employees_id as eID, a.account_img_url, n.fname, n.mname, n.lname, v.venue, a.account_img_url
		FROM bldg_coordinators b 
		JOIN venues v ON v.venue_id = b.venue_id 
		JOIN employees e ON e.employees_id = b.employees_id 
		JOIN accounts a ON a.account_id = e.account_id
		JOIN names n ON n.name_id = e.name_id
		WHERE b.removed = 0
		");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$fullname = formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname);
		$sql[$i]->account_img_url = '<img src="'. assets($sql[$i]->account_img_url) .'" class="avatar" alt="">';
		$sql[$i]->fullname = '<a href="javascript:" class="d-block text-dark student_name">'. $fullname .'</a><small class="folnamet-weight-light font-italic text-muted font-07">'. $sql[$i]->employee_id .'</small>';
		$sql[$i]->options = '
			<div class="btn-group">
				<button class="btn btn-primary btn-sm call_modal_edit_bldg_coordinator" data-bldg_coordinator_id="'. $sql[$i]->bldg_coordinator_id .'"  data-employees_id="'. $sql[$i]->eID. '" data-employee_name="'. $fullname .'">Edit</button>
				<button class="btn btn-warning btn-sm call_modal_remove_bldg_coordinator" data-bldg_coordinator_id="'. $sql[$i]->bldg_coordinator_id .'" data-employee_name="'. $fullname .'" data-venue="'. $sql[$i]->venue .'">Remove</button>
			</div>
		';

		unset($sql[$i]->employee_id);
		unset($sql[$i]->fname);
		unset($sql[$i]->mname);
		unset($sql[$i]->mname);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_bldg_coordinator_available_venues'])){
	$sql = $init->getData("SELECT venue_id, venue, image_url FROM venues WHERE venue_id NOT IN (SELECT venue_id FROM bldg_coordinators WHERE removed = 0) AND venues.removed = 0");
	
	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->img_src = assets($sql[$i]->image_url);
	}

	echo json_encode($sql);
}

if(isset($_POST['get_bldg_coordinator_from_employee_id'])){
	$employee_id = $init->post('get_bldg_coordinator_from_employee_id');
	$json = array();

	$sql = $init->getData("SELECT n.fname, n.mname, n.lname 
			FROM employees e 
			JOIN names n ON e.name_id = n.name_id 
			JOIN accounts a ON a.account_id = e.account_id
			WHERE e.employee_id = '$employee_id' 
			AND a.removed = 0");

	$count = count($sql);
	$json['count'] = $count;

	if($count > 0){

		$mname = (acronym($sql[0]->mname) == '') ? '' : acronym($sql[0]->mname) . '.';
		$json['name'] = $sql[0]->fname . ' ' . $mname . ' ' . $sql[0]->lname;
	}

	echo json_encode($json);
}

if(isset($_POST['register_bldg_coordinator'])){
	$employee_id = $init->post('register_bldg_coordinator');
	$venue_id = $init->post('venue_id');
	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	if(!validate([$employee_id, $venue_id])){
		$json['message'] = "<b>Error!</b> Fields cannot be left empty!";
	} else{
		$get_id_sql = $init->getData("SELECT employees.employees_id, names.fname, names.lname FROM employees JOIN names ON names.name_id = employees.name_id WHERE employee_id = '$employee_id'");

		$employees_id = $get_id_sql[0]->employees_id;
		$fname = $get_id_sql[0]->fname;
		$lname = $get_id_sql[0]->lname;

		$check_sql = $init->getData("SELECT * FROM bldg_coordinators WHERE venue_id = '$venue_id' AND employees_id = '$employees_id' AND removed = 1");

		if(count($check_sql) > 0){
			$bldg_coordinator_id = $check_sql[0]->bldg_coordinator_id;

			$sql = $init->query("UPDATE bldg_coordinators SET removed = 0 WHERE bldg_coordinator_id = '$bldg_coordinator_id'");

			if($sql){
				$audit->audit("Registered a new building coordinator");
				$json['bool'] = true;
				$json['message'] = "Successfully registered $fname $lname as a building coordinator";
				$json['alert'] = 'success';
			}
		} else{
			$sql = $init->query("INSERT INTO bldg_coordinators(employees_id, venue_id) VALUES('$employees_id', '$venue_id')");

			if($sql){
				$json['bool'] = true;
				$json['message'] = "Successfully registered $fname $lname as a building coordinator";
				$json['alert'] = 'success';
			}
		}
	}

	echo json_encode($json);
	unset($json);
}

if(isset($_POST['edit_bldg_coordinator'])){
	$bldg_coordinator_id = $init->post('edit_bldg_coordinator');
	$venue_id = $init->post('venue_id');
	$employees_id = $init->post('employees_id');

	$json = array();

	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	if(!validate([$bldg_coordinator_id, $venue_id])){
		$json['message'] = "<b>Error!</b> Fields cannot be left empty!";
	} else{

		$check_sql = $init->getData("SELECT * FROM bldg_coordinators WHERE venue_id = '$venue_id' AND employees_id = '$employees_id' AND removed = 1");

		if(!count($check_sql) > 0){
			$sql = $init->query("UPDATE bldg_coordinators SET venue_id = '$venue_id' WHERE bldg_coordinator_id = '$bldg_coordinator_id'");

			if($sql){
				$audit->audit("Updated a building coordinator");
				$json['bool'] = true;
				$json['message'] = "Successfully updated building coordinator!";
				$json['alert'] = 'success';
			}
		}
	}

	echo json_encode($json);
}

if(isset($_POST['remove_bldg_coordinator'])){
	$bldg_coordinator_id = $init->post('remove_bldg_coordinator');

	$json = array();

	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	$sql = $init->query("UPDATE bldg_coordinators SET removed = 1 WHERE bldg_coordinator_id = '$bldg_coordinator_id'");

	if($sql){
		$audit->audit("Removed a building coordinator");
		$json['bool'] = true;
		$json['message'] = "Successfully removed building coordinator!";
		$json['alert'] = 'success';
	}

	echo json_encode($json);
}