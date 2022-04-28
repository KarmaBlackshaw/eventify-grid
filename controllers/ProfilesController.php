<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;

if(isset($_POST['my_profile_information'])){
	$student_id = $_SESSION['student_id'];

	$json = $init->getData("SELECT u.student_id, u.fname, u.lname, u.user_number, u.parent_number, u.username, u.created_at, u.updated_at, s.section, s.year_level, d.department, c.course 
		FROM users u JOIN sections s ON u.section_id = s.section_id 
		JOIN departments d ON s.department_id = d.department_id 
		JOIN courses c ON s.course_id = c.course_id 
		WHERE u.student_id = '$student_id'");

	$created_at = new Carbon($json[0]->created_at);
	$updated_at = new Carbon($json[0]->updated_at);
	$json[0]->new_created_at = $created_at->format('D, M d, Y h:iA');
	$json[0]->new_updated_at = $updated_at->format('D, M d, Y h:iA');
	$json[0]->new_year_level = ordinal($json[0]->year_level) . ' Year';
	echo json_encode($json);
}

if(isset($_POST['dropdown_department'])){
	$json = $init->getData("SELECT * FROM departments d WHERE removed = 0");

	echo json_encode($json);
}