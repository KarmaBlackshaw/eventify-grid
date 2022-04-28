<?php

require_once dirname(__DIR__) . '/lib/init.php';
$audit = new Audit;
$adviser = new Adviser;

if(isset($_POST['load_student_name'])){
	$student_id = $init->post('load_student_name');
	$json = array();

	$sql = $init->getData("SELECT names.fname, names.mname, names.lname FROM students JOIN names ON names.name_id = students.name_id WHERE students.students_id NOT IN(SELECT students_id FROM ssc WHERE removed = 0) AND students.student_id = '$student_id'");

	$json['count'] = count($sql);

	if(count($sql) > 0){
		$json['name'] = $sql[0]->fname . ' ' . acronym($sql[0]->mname) . '. ' . $sql[0]->lname;
	}

	echo json_encode($json);
}

if(isset($_POST['load_ssc_positions'])){
	$sql = $init->getData("SELECT position, position_id FROM positions WHERE user_level_id = 6 AND position_id NOT IN (SELECT position_id FROM ssc WHERE removed = 0) AND position_id <> '19'");

	echo json_encode($sql);
}

if(isset($_POST['btn_add_officers'])){
	$student_id = $init->post('btn_add_officers');
	$position_id = $init->post('position_id');

	$json['bool'] = false;
	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	if(!validate([$student_id, $position_id])){
		$json['message'] = "<b>Error!</b> Fields cannot be left empty!";
	} else{
		$position_count = $init->count("SELECT * FROM ssc WHERE position_id = '$position_id' AND removed = 0");

		if($position_count > 0){
			$json['message'] = "<b>Error!</b> Position is still occupied!";
		} else{
			$student_sql = $init->getData("SELECT students.students_id, contacts.user_contact, accounts.account_id 
				FROM students 
				JOIN contacts ON contacts.contact_id = students.contact_id 
				JOIN accounts ON accounts.account_id = students.account_id
				WHERE students.student_id = '$student_id'");

			$students_id = $student_sql[0]->students_id;
			$user_contact = $student_sql[0]->user_contact;
			$account_id = $student_sql[0]->account_id;
			
			$ssc_sql = $init->query("INSERT INTO ssc(students_id, position_id) VALUES('$students_id', '$position_id')");

			if($ssc_sql){
				$audit->audit("Added new Supreme Student Council Officer");
				$sql = $init->query("UPDATE accounts SET user_level_id = '6' WHERE account_id = '$account_id'");

				if($sql){
					// sms($sms, [$user_contact], 'Congratulations! Your account is now SSC Officer level');

					$json['bool'] = true;
					$json['alert'] = 'success';
					$json['message'] = "Successfully promoted $student_id to SSC Officer!";
				}
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['load_table_officers_manage'])){
	$sql = $init->getData("SELECT s.student_id, n.fname, n.mname, n.lname, p.position, s.year_level, d.department, a.account_img_url
		FROM ssc 
		JOIN students s ON s.students_id = ssc.students_id 
		JOIN names n ON n.name_id = s.name_id
		JOIN positions p ON p.position_id = ssc.position_id
		JOIN departments d ON d.department_id = s.department_id 
		JOIN accounts a ON a.account_id = s.account_id
		WHERE ssc.removed = 0 AND a.removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$name = formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname);
		$sql[$i]->img_src = '<img src="'. assets($sql[$i]->account_img_url) .'" alt="" class="avatar mr-3 align-self-center">';
		$sql[$i]->student_id_small = '<small class="font-italic text-secondary">'. $sql[$i]->student_id .'</small>';
		$sql[$i]->year_levels = ordinal($sql[$i]->year_level) . ' Year';
		$sql[$i]->name_formatted = '<a href="javascript:" class="d-block text-dark student_name">'. formatName($sql[$i]->fname, $sql[$i]->mname, $sql[$i]->lname) .'</a><small class="font-weight-light font-italic text-muted font-07">'. $sql[$i]->student_id .'</small>';
		$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:void(0)" class="dropdown-item load_modal_demote_ssc" data-target="'. $sql[$i]->student_id .'" data-name="'. $name .'"><i class="dropdown-icon fe fe-heart"></i> Demote </a>
			</div>
		</div>';
	}

	echo json_encode($sql);
}

if(isset($_POST['btn_demote_ssc'])){
	$student_id = $init->post('btn_demote_ssc');

	$ssc_sql = $init->query("UPDATE ssc JOIN students ON students.students_id = ssc.students_id SET ssc.removed = 1 WHERE students.student_id = '$student_id'");

	if($ssc_sql){
		$audit->audit("Demoted a Supreme Student Council Member");
		$account_sql = $init->query("UPDATE accounts JOIN students ON students.account_id = accounts.account_id SET user_level_id = '5' WHERE students.student_id = '$student_id'");

		if($account_sql){
			$json['bool'] = true;
			$json['alert'] = 'success';
			$json['message'] = "Successfully demoted $student_id to student!";	
		} else{
			$json['bool'] = false;
			$json['alert'] = 'danger';
			$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
		}
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['load_table_ssc_positions'])){
	$sql = $init->getData("SELECT * FROM positions WHERE removed = 0 AND user_level_id = 6");

	foreach($sql as $data){
		$data->status = $adviser->positionIsOccupied($data->position_id) ? '<span class="w-100 hvr-grow badge badge-success p-2">Occupied</span>' : '<span class="w-100 hvr-grow badge badge-warning p-2">Empty</span>';
		$data->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:void(0)" class="dropdown-item call_modal_edit_position" data-position="'. $data->position .'" data-position_id="'. $data->position_id .'"><i class="dropdown-icon fe fe-edit"></i> Edit </a>
				<a href="javascript:void(0)" class="dropdown-item call_modal_remove_position" data-position="'. $data->position .'" data-position_id="'. $data->position_id .'"><i class="dropdown-icon fe fe-trash"></i> Remove </a>
			</div>
		</div>';
	}

	echo json_encode($sql);
}

if(isset($_POST['remove_position'])){
	$position_id = $init->post('remove_position');

	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	$sql = $init->query("UPDATE positions SET removed = 1 WHERE position_id = {$position_id}");

	if($sql){
		$json['alert'] = 'success';
		$json['message'] = 'Successfully removed position!';
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['edit_position'])){
	$position_id = $init->post('edit_position_id');
	$position = $init->post('edit_position');

	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	if(!empty($position)){
		$count = $init->getData("SELECT COUNT(*) total FROM positions WHERE position = '$position' AND user_level_id = 6");
		$count = $count[0]->total;

		if($count > 0){
			$json['message'] = "<b>Error!</b> Position already exists!";
		} else{
			$sql = $init->query("UPDATE positions SET position = '$position' WHERE position_id = '$position_id'");

			if($sql){
				$json['alert'] = 'success';
				$json['message'] = 'Successfully updated position';
			}
		}
	} else{
		$json['message'] = '<b>Error!</b> Fields cannot be left empty!';
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['add_position'])){
	$position = $init->post('add_position');
	
	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	if(!empty($position)){
		$sql = $init->getData("SELECT * FROM positions WHERE position = '$position' AND user_level_id = 6");

		if(!empty($sql)){
			if($sql[0]->removed == 0){
				$json['message'] = "<b>Error!</b> Position already exists!";
			} else{
				$position_id = $sql[0]->position_id;
				$sql = $init->query("UPDATE positions SET removed = 0 WHERE position_id = '$position_id'");

				if($sql){
					$json['alert'] = 'success';
					$json['message'] = 'Successfully restored position';
				}
			}
		} else{
			$sql = $init->query("INSERT INTO positions(position, user_level_id) VALUES('$position', 6)");

			if($sql){
				$json['alert'] = 'success';
				$json['message'] = 'Successfully added a new position';
			}
		}
	} else{
		$json['message'] = '<b>Error!</b> Fields cannot be left empty!';
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}