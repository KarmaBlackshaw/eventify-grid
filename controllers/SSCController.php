<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;
$last_day_of_december = new Carbon('last day of December');
// Add Events

if(isset($_POST['events_add_propose'])){
	$ssc = new SSC;

	$post = $_POST;
	$json = array();
	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = 'danger';

	$validate = check_err($post);

	if(count($validate)  > 0){
		$json['message'] = $validate;
	} else{
		$event = $init->post('event');
		$description = $init->post('description');
		$attendance = $init->post('attendance');
		$money = $init->post('money');
		$time_start = $init->post('time_start');
		$time_end = $init->post('time_end');
		$college = $init->post('college');
		$year_level = $init->post('year_level');
		$content = $init->post('content');
		$venue_id = $init->post('venue');
		$party = $init->post('party');
		$date_start = $init->post('date_start');
		$date_end = $init->post('date_end');
		$date_period = json_encode(SSC::periodToArray($date_start, $date_end));
		$event_type = $init->post('event_type');
		$event_id = '';

		if(!$ssc->sscCompleteCheck()){
			$json['message'] = '<b>Error!</b> SSC are not yet complete! Please register all SSC to their corresponding positions!';
		} else{
			$count_event = $init->count("SELECT * FROM events WHERE event = '$event' AND recipient_department = '$college' AND recipient_year_level = '$year_level' AND date_of_use = '$date_period'");

			if($count_event == 0){
				$time = $time_start . '%' . $time_end;

				$event_sql = $init->query("INSERT INTO events(event, description, event_type_id, attendance, recipient_department, recipient_year_level, proposal, requesting_party, account_id, date_of_use, inclusive_time) VALUES('$event', '$description', '$event_type', '$attendance', '$college', '$year_level', '$content', '$party', {$_SESSION['account_id']} , '$date_period', '$time')");

				if($event_sql){
					$event_id = $init->insert_id();

					if(isset($_POST['item_id'])){
						$reservation_sql = $ssc->reserve($_POST['item_id'], $_POST['quantity'], $event_id, $venue_id);
					} else{
						$reservation_sql = $init->query("INSERT INTO reservations(event_id, facility_item_id, item_quantity, venue_id) VALUES('$event_id', NULL, NULL, '$venue_id')");
					}

					if($reservation_sql){
						$sql = $ssc->insertApprovers($money, $venue_id, $event_id);

						if($sql){
							$sms = $ssc->notifySSC("Good day officer! A new event entitled $event has been proposed! Please visit your account to approved the event!");

							if($sms){
								$json['alert'] = 'warning';
								$json['message'] = "Something went wrong with the SMS Notification but the event was successfully proposed!";
							} else{
								$json['alert'] = 'success';
								$json['message'] = "Successfully added event to the approval queue!";
							}

							$audit->audit("Proposed an event: $event");
							$json['bool'] = true;
						}
					}
				}
			} else{
				$sql = $ssc->deleteEvent($event_id);
				$json['message'] = "<b>Error!</b> Event is already registered!";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['load_available_venues'])){
	$date_start = $init->post('start');
	$date_end = $init->post('end');

	if($date_start && $date_end){
		$period = SSC::periodToArray($date_start, $date_end);

		$start = reset($period);
		$end = end($period);

		$sql = $init->getData('SELECT v.venue, v.venue_id 
			FROM venues v 
			WHERE venue_id NOT IN 
			(SELECT v.venue_id 
			FROM events e
			JOIN reservations r ON r.event_id = e.event_id 
			JOIN venues v ON v.venue_id = r.venue_id 
			WHERE e.date_of_use 
			LIKE "%' . $start . '%" OR date_of_use LIKE "%'. $end .'%")
			AND venue_id IN
			(SELECT venue_id FROM bldg_coordinators WHERE removed = 0)
			');

		echo json_encode($sql);
	}
}

if(isset($_POST['load_facilities_table'])){
	$json = array();

	if(isset($_POST['facilities'])){
		$facilities = $_POST['facilities'];
		$text = "'" . implode( "', '" , $facilities) . "'";
		$query = "SELECT facility_items.facility_item_id, facility_items.item, facility_items.quantity, facilities.facility, facility_items.img_url 
		FROM facility_items 
		JOIN facilities ON facilities.facility_id = facility_items.facility_id
		WHERE facility_items.facility_item_id IN ($text)";
		
		$json = $init->getData($query);
		
	}
	
	echo json_encode($json);
}

// Manage Events
if(isset($_POST['load_events_manage'])){
	$sql = $init->getData("SELECT e.event_id, e.event, e.requesting_party, e.date_of_use, e.status_id, e.event_img, v.venue, s.status, types.type 
		FROM events e 
		JOIN event_types types ON types.event_type_id = e.event_type_id
		LEFT JOIN reservations r ON r.event_id = e.event_id 
		LEFT JOIN status s ON s.status_id = e.status_id 
		LEFT JOIN venues v ON v.venue_id = r.venue_id
		ORDER BY e.created_at ASC");

	$ssc = new SSC;
	$count = count($sql);
	$date_count = '';
	$date = [];
	$json = [];

	for($i = 0; $i < $count; $i++){
		$date = json_decode($sql[$i]->date_of_use);
		$self_status = $ssc->checkSelfEventStatus($sql[$i]->event_id);

		$date_start = reset($date);
		$date_end = end($date);

		$sql[$i]->first = Carbon::createFromFormat('Y-m-d', $date_start);
		$sql[$i]->last = Carbon::createFromFormat('Y-m-d', $date_end);

		$ssc->updateEventStatus($date_start, $date_end, $sql[$i]->event_id);

		$status_id = $sql[$i]->status_id;
		$status = $sql[$i]->status;

		$sql[$i]->status_badge = $ssc->getStatusBadge($status_id, $status);

		if($self_status){ // Approve
			$sql[$i]->event_formatted = '<span class="no-wrap" title="Approved"><i class="fas fa-circle fa-xs text-success font-06 mr-1 pb-1"></i>'. $sql[$i]->event . '</span>';
			$sql[$i]->self_status = 'self:Approved';
		} elseif(is_null($self_status)){ // Idle
			$sql[$i]->event_formatted = '<span class="no-wrap" title="Idle"><i class="fas fa-circle fa-xs text-secondary font-06 mr-1 pb-1"></i>'. $sql[$i]->event . '</span>';
			$sql[$i]->self_status = 'self:Idle';
		} elseif($self_status === FALSE){
			$sql[$i]->event_formatted = '<span class="no-wrap" title="Not Approver"><i class="fas fa-circle fa-xs text-warning font-06 mr-1 pb-1"></i>'. $sql[$i]->event . '</span>';
			$sql[$i]->self_status = 'self:Not';
		} else{ // Disapproved
			$sql[$i]->event_formatted = '<span class="no-wrap" title="Disapproved"><i class="fas fa-circle fa-xs text-danger font-06 mr-1 pb-1"></i>'. $sql[$i]->event . '</span>';
			$sql[$i]->self_status = 'self:Disapproved';
		}

		$sql[$i]->event_proposal_link = base_views('ssc/events/pdf_events', 'e=' . $sql[$i]->event_id);
		$sql[$i]->event_approval_link = base_views('ssc/events/pdf_events_approval', 'e=' . $sql[$i]->event_id);

		// Options
		$event_approve = '<a href="javascript:" class="dropdown-item event_approve" data-event_id="'. $sql[$i]->event_id .'"><i class="dropdown-icon fe fe-heart"></i> Approve </a>';
		$event_disapprove = '<a href="javascript:" class="dropdown-item event_disapprove" data-event_id="'. $sql[$i]->event_id .'" data-event="'. $sql[$i]->event .'"><i class="dropdown-icon fe fe-thumbs-down"></i> Disapprove </a>';
		$event_status = '<a href="javascript:" class="dropdown-item event_status" data-event_id="'. $sql[$i]->event_id .'" data-event="'. $sql[$i]->event .'" ><i class="dropdown-icon fe fe-info"></i> Status </a>';
		$event_view = '<a href="javascript:" class="dropdown-item call_modal_view_event" data-event_id="'. $sql[$i]->event_id .'"><i class="dropdown-icon fe fe-eye"></i> View </a>';
		$event_download = '<a href="'. $sql[$i]->event_proposal_link .'" target="_blank" class="dropdown-item open_pdf_content" data-event_id="'. $sql[$i]->event_id .'"><i class="dropdown-icon  fe fe-download"></i> Download Proposal </a>';
		$event_approval_pdf = '<a href="'. $sql[$i]->event_approval_link .'" target="_blank" class="dropdown-item open_pdf_content" data-event_id="'. $sql[$i]->event_id .'"><i class="dropdown-icon  fe fe-download"></i> Download Approval </a>';

		switch ($status_id) {
			case 3: // Pending
				if($self_status){ // Approve
					$sql[$i]->options = '<div class="item-action dropdown">
					<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
					'. $event_status .'
					'. $event_view .'
					'. $event_download .'
					'. $event_approval_pdf .'
					</div>
					</div>';
				} elseif(is_null($self_status)){
					$sql[$i]->options = '<div class="item-action dropdown">
					<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
					'. $event_approve .'
					'. $event_disapprove .'
					'. $event_status .'
					'. $event_view .'
					'. $event_download .'
					'. $event_approval_pdf .'
					</div>
					</div>';
				} else{
					$sql[$i]->options = '<div class="item-action dropdown">
					<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
					'. $event_status .'
					'. $event_view .'
					'. $event_download .'
					'. $event_approval_pdf .'
					</div>
					</div>';
				}
				break;

			case 4: // Approved
			$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
			'. $event_disapprove .'
			'. $event_status .'
			'. $event_view .'
			'. $event_download .'
			'. $event_approval_pdf .'
			</div>
			</div>';
			break;
			
			default: // Finished
			$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
			'. $event_status .'
			'. $event_view .'
			'. $event_download .'
			'. $event_approval_pdf .'
			</div>
			</div>';
			break;
		}

		$sql[$i]->date_period = $sql[$i]->first->toFormattedDateString() .' - '. $sql[$i]->last->toFormattedDateString();		
		$sql[$i]->hash = md5($sql[$i]->event_id);		
		

		unset($sql[$i]->date_of_use);
		unset($sql[$i]->first);
		unset($sql[$i]->last);
		unset($sql[$i]->status);
	}

	echo json_encode($sql);
}

if(isset($_POST['modal_school_calendar_event_hidden'])){
	$event = $init->post('modal_school_calendar_event_name');
	$event = $init->post('modal_school_calendar_event_date');
	$file = $_FILES['modal_school_calendar_event_image'];
	$image_bool = false;

	if(!empty($file['name'])){
		$file_name = $file['name'];
		$file_name = $file['type'];
		$file_name = $file['tmp_name'];
		$file_name = $file['name'];
	}
}

if(isset($_POST['load_event_info_for_approval'])){
	$ssc = new SSC;

	$event_id = $init->post('load_event_info_for_approval');

	$sql = $init->getData("SELECT e.event, e.recipient_department, e.recipient_year_level, e.requesting_party, e.account_id, e.date_of_use, e.inclusive_time, v.venue, r.facility_item_id, r.item_quantity
		FROM events e 
		LEFT JOIN reservations r ON r.event_id = e.event_id
		LEFT JOIN facility_items i ON r.facility_item_id = i.facility_item_id
		LEFT JOIN venues v ON v.venue_id = r.venue_id
		WHERE e.event_id = '$event_id'
		");

	// Start Datetime
	$period = json_decode($sql[0]->date_of_use);

	$time = explode('%', $sql[0]->inclusive_time);
	$start = Carbon::createFromFormat('Y-m-d', reset($period))->toFormattedDateString();
	$end = Carbon::createFromFormat('Y-m-d', end($period))->toFormattedDateString();
	// echo $time[0];
	$time_start = Carbon::createFromFormat('G:i', reset($time))->format('g:iA');
	$time_end = Carbon::createFromFormat('G:i', end($time))->format('g:iA');
	// End Datetime

	// Start Recipients
	$department_explode = explode(',', $sql[0]->recipient_department);
	$year_level_explode = explode(',', $sql[0]->recipient_year_level);
	$recipient = array();

	foreach($department_explode as $dep_data){
		$sql_department = $init->getData("SELECT department FROM departments WHERE department_id = {$dep_data}");

		foreach($year_level_explode as $year_data){
			$ordinal = ordinal($year_data);
			$recipient[] = $sql_department[0]->department .  " (<small class='font-italic'>$ordinal Year</small>)";
		}
	}
	// End Recipients

	// Start Facility
	$facility_item_arr = array();
	$facility_item_qty = array();

	$exploded_items = explode(', ', $sql[0]->facility_item_id);
	$exploded_qty = explode(', ', $sql[0]->item_quantity);

	$count = count($exploded_items);

	for($i = 0; $i < $count; $i++){
		$sql_item = $init->getData("SELECT item FROM facility_items WHERE facility_item_id = '{$exploded_items[$i]}'");

		if($sql_item){
			$facility_item_arr[] = $sql_item[0]->item;
			$facility_item_qty[] = $exploded_qty[$i] . ' pcs';
		}
	}
	// End Facility

	// Wrap things
	foreach($sql as $data){
		$data->facility_item_arr = $facility_item_arr;
		$data->facility_item_qty = $facility_item_qty;
		$data->recipient = $recipient;
		$data->composer = $ssc->getFormattedName($sql[0]->account_id);
		$data->adviser_name = $ssc->getSscAdviserName();
		$data->date_of_usage = $start . ' - ' . $end;
		$data->time = $time_start . ' - ' . $time_end;
		$data->controllers = base_views('ssc/events/pdf_events', 'e=' . $event_id);
		$data->event_id = $event_id;
	}

	unset($sql[0]->facility_item_id);
	unset($sql[0]->item_quantity);
	unset($sql[0]->recipient_department);
	unset($sql[0]->recipient_year_level);
	unset($sql[0]->date_of_use);
	unset($sql[0]->inclusive_time);

	echo json_encode($sql);
}

if(isset($_POST['modal_approve_event'])){
	$ssc = new SSC;
	$event_id = $init->post('modal_approve_event');

	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "success";
	$json['bool'] = true;

	if($ssc->approveEvent($event_id)){

		$audit->audit("Approved an event");
		$json['message'] = "You have successfully approved the event!";
		$json['alert'] = "success";
		$json['bool'] = true;
	}

	if($ssc->checkSSCApproved($event_id)){
		SSC::sms([$ssc->getEventBldgCoordinator($event_id)], "A new event has been proposed by the Supreme Student Council. Please log in to your account for more information!");
		SSC::sms([$ssc->getOsaAccountID()->user_contact], "A new event has been proposed by the Supreme Student Council. Please log in to your account for more information!");
	}

	echo json_encode($json);
}

if(isset($_POST['modal_disapprove_event'])){
	$ssc = new SSC;
	$event_id = $init->post('modal_disapprove_event');

	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";
	$json['bool'] = false;

	if($ssc->disapproveEvent($event_id)){
		$json['message'] = "You have successfully disapproved the event!";
		$json['alert'] = "success";
		$json['bool'] = true;
	}

	echo json_encode($json);
}

if(isset($_POST['load_event_status'])){
	$event_id = $init->post('load_event_status');

	$sql = $init->getData("SELECT app.approved, p.position, n.fname, n.mname, n.lname, o.office 
		FROM approvals app
		LEFT JOIN positions p ON p.position_id = app.position_id
		LEFT JOIN accounts a ON a.account_id = app.account_id
		LEFT JOIN employees e ON e.account_id = a.account_id
		LEFT JOIN students s ON s.account_id = a.account_id 
		LEFT JOIN ssc ON ssc.students_id = s.students_id AND ssc.removed = 0
		LEFT JOIN names n ON n.name_id = s.name_id OR n.name_id = e.name_id
		LEFT JOIN offices o ON o.office_id = p.office_id
		WHERE app.event_id = '$event_id'
		");

	foreach($sql as $data){
		// Icon
		if($data->approved){
			$data->icon = '<i class="fe fe-check-circle text-green"></i>';
		} elseif(is_null($data->approved)){
			$data->icon = '<i class="fe fe-circle text-secondary"></i>';
		} else{
			$data->icon = '<i class="fe fe-x-circle text-danger"></i>';
		}

		// Office
		if(is_null($data->office)){
			$data->office = "Supreme Student Council";
		}

		$data->offices = "<small class='font-italic'>$data->office</small>";

		// Name
		$middle = (acronym($data->mname) == '') ? '' :  acronym($data->mname) . '.';
		$data->name = "<span class='no-wrap font-weight-bold'>$data->fname  $middle  $data->lname</span>";
		$data->positions = "<small class='font-italic'>$data->position</small>";


		unset($data->approved);
		unset($data->fname);
		unset($data->mname);
		unset($data->lname);
	}

	echo json_encode($sql);
}

// Calendar

if(isset($_GET['calendar_io'])){
	$sql = $init->getData("SELECT school_calendar_id, event, date_of_use FROM school_calendar WHERE removed = 0");

	$count = count($sql);
	$date_start = array();

	for($i = 0; $i < $count; $i++){ 
		// 
		$date = Carbon::parse($sql[$i]->date_of_use)->format('Y-m-d');
		
		$data[] = array(
			'id' 	=> $sql[$i]->school_calendar_id,
			'title' => $sql[$i]->event,
			'start' => $date,
			'end' 	=> $date
		);
	}

	echo json_encode($data);
}

if(isset($_POST['school_calendar'])){
	$event = $init->post('school_calendar');
	$date = $init->post('date');

	$json = array();
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	if(!validate([$event, $date])){
		$json['message'] = "<b>Error!</b> Fields cannot be left empty!";
	} else{
		$count = $init->count("SELECT * FROM school_calendar WHERE event = '$event'");

		if($count > 0){
			$json['message'] = "<b>Error!</b> Event already exists!";
		} else{
			$sql = $init->query("INSERT INTO school_calendar(event, date_of_use, account_id) VALUES('$event', '$date', {$_SESSION['account_id']})");

			if($sql){
				$json['message'] = "Successfully added event to the school calendar!";
				$json['alert'] = "success";
			}
		}
	}

	echo json_encode($json);
}

if($last_day_of_december->isToday()){
	$sql = $init->getData("SELECT school_calendar_id, date_of_use FROM school_calendar");

	foreach($sql as $data){
		$raw = $data->date_of_use;
		$explode = explode('-', $raw);
		$year_now = Carbon::now()->year;
		$year = $explode[0];
		$month = $explode[1];
		$day = $explode[2];

		if($year_now == $year){
			break;
		} else{
			$new_date = "$year-$month-$day";
			$sql = $init->query("UPDATE school_calendar SET date_of_use = '$new_date' WHERE school_calendar_id = {$data->school_calendar_id}");
		}
	}
}

// Reports
if(isset($_POST['load_student_table'])){
	$ssc = new SSC;

	$sql = $ssc->getActiveStudents();

	foreach($sql as $data){
		$data->name = formatName($data->fname, $data->mname, $data->lname);
		$data->account_img_url = '<img src="'. assets($data->account_img_url) .'" class="avatar" alt="">';
		// $data->department = acronym($data->department);
		$data->year_level = ordinal($data->year_level) . " Year";
		$data->formatted_name = '<a href="javascript:" class="d-block text-dark student_name" data-students_id="'. $data->students_id .'">'. $data->name .'</a><small class="font-weight-light font-italic text-muted font-07">'. $data->student_id .'</small>';
		$data->options = '<div class="item-action dropdown">
		<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
		<a href="javascript:" class="dropdown-item view_reports" 
		data-students_id="'. $data->students_id .'"
		data-student_name="'. $data->name .'" >
		<i class="dropdown-icon fe fe-eye"></i> View Reports 
		</a>
		</div>
		</div>';

		unset($data->students_id);
		unset($data->name_id);
		unset($data->contact_id);
		unset($data->account_id);
		unset($data->created_at);
		unset($data->updated_at);
		unset($data->username);
		unset($data->password);
		unset($data->user_level_id);
		unset($data->activation_code);
		unset($data->activated);
		unset($data->removed);
		unset($data->fname);
		unset($data->mname);
		unset($data->lname);
		unset($data->department_id);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_events_table_for_import'])){
	$ssc = new SSC;

	$sql = $ssc->getApprovedEvents();

	foreach($sql as $data){
		$raw_date = json_decode($data->date_of_use);
		$first_date = Carbon::createFromFormat('Y-m-d', reset($raw_date));
		$last_date = Carbon::createFromFormat('Y-m-d', end($raw_date));
		$data->date_of_use = formatDate($first_date, $last_date);
		$data->attendance = ($data->attendance) ? '<span class="badge badge-success w-100">Yes</span>' : '<span class="badge badge-warning w-100">No</span>';

		$raw_time = explode('%', $data->inclusive_time);
		$data->inclusive_time = reset($raw_time) . ' - ' . end($raw_time);

		$data->event = "<b>" . strtoupper($data->event) . "</b>";

		$data->options = '<div class="item-action dropdown">
		<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
		<a href="javascript:" class="dropdown-item call_modal_import_attendance" data-event_id="'. $data->event_id .'"><i class="dropdown-icon fe fe-send"></i> Import </a>
		<a href="javascript:" class="dropdown-item call_modal_view_import" data-event_id="'. $data->event_id .'"><i class="dropdown-icon fe fe-eye"></i> View Status </a>
		<a href="'. base_views('ssc/reports/pdf_event_attendance', 'id=' . $data->event_id) .'" target="__blank" class="dropdown-item"><i class="dropdown-icon fe fe-eye"></i> View Attendance </a>
		</div>
		</div>';

		unset($data->description);
		unset($data->recipient_department);
		unset($data->recipient_year_level);
		unset($data->status_id);
		unset($data->proposal);
		unset($data->account_id);
		unset($data->created_at);
		unset($data->updated_at);
		unset($data->removed);
		unset($data->event_type_id);
		unset($data->event_img);
	}

	echo json_encode($sql);
}

if(isset($_POST['import_file_hidden'])){
	// print_r($_FILES);
	$ssc = new SSC;
	$file = $_FILES['import_file'];
	$event_id = $init->post('import_file_hidden');

	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	if(!empty($file['name'])){
		if($file['type'] == 'text/plain'){
			$exp = explode('.', $file['name']);
			$type = end($exp);

			if($type == 'txt'){
				$array = $ssc->getBiometricData($file['tmp_name']);

				if(!$ssc->biometricDateMatches($event_id, Carbon::createFromFormat('Y/m/d', reset($array['date']))->format('Y-m-d') )){
					$json['message'] = "<b>Error!</b> The event date and the date in the biometric does not match!";
				} else{
					$str = '';

					$count = count($array['student_id']);

					for($i = 0; $i < $count; $i++){
						$student_id = $array['student_id'][$i];
						$time_in = $array['time_in'][$i];
						$time_out = $array['time_out'][$i];
						$date = Carbon::createFromFormat('Y/m/d', $array['date'][$i])->format('Y-m-d');

						if(!$ssc->biometricDataExists($event_id, $student_id, $date)){
							$str .= "('$event_id', '$student_id', '$time_in', '$time_out', '$date'),";
						}
					}

					$str = rtrim($str, ',');

					if(!empty($str)){
						$audit->audit("Imported biometric data!");
						$sql = $init->query("INSERT INTO attendance (event_id, student_id, time_in, time_out, event_date) VALUES $str");


						if($sql){
							$json['message'] = "Successfully imported data into the system!";
							$json['alert'] = "success";
						}
					} else{
						$json['message'] = "<b>Notice!</b> Data already exists in the database. No data is uploaded.";
						$json['alert'] = "warning";
					}
				}
			} else{
				$json['message'] = "<b>Error!</b> File type should only be a plain text!";
			}
		} else{
			$json['message'] = "<b>Error!</b> File type should only be a plain text!";
		}
	} else{
		$json['message'] = "<b>Error!</b> Cannot import empty file!";
	}

	$json['error'] = $init->error();
	echo json_encode($json);
}

if(isset($_POST['call_modal_view_import'])){
	$event_id = $init->post('call_modal_view_import');
	$json = [];
	
	$sql = $init->getData("
			SELECT date_of_use
			FROM events e
			WHERE e.event_id = '$event_id'
		");

	$date_arr = json_decode($sql[0]->date_of_use);

	foreach($date_arr as $data){
		// $count = $init->getData("SELECT COUNT(*) x, created_at FROM attendance WHERE event_id = $event_id AND event_date = '$data'");
	$count = $init->getData("SELECT COUNT(*) x, created_at FROM attendance WHERE event_id = $event_id AND event_date = '$data'");
		$json['count'][] = $count[0]->x > 0 ? '<span class="w-100 badge badge-success">Imported</span>' : '<span class="w-100 badge badge-secondary">Empty</span>';
		$json['event_date'][] = Carbon::createFromFormat('Y-m-d', $data)->format('F d, Y');
		$json['import_date'][] = is_null($count[0]->created_at) ? 'No import yet!' : Carbon::createFromFormat('Y-m-d H:i:s', $count[0]->created_at)->calendar();
	}

	echo json_encode($json);
}

if(isset($_POST['clear_student'])){
	$event_id = $init->post('clear_student');
	$student_id = $init->post('student_id');
	$date = $init->post('date');

	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator";
	$json['alert'] = "danger";

	$sql = $init->query("INSERT INTO attendance(event_id, student_id, time_in, time_out, event_date) VALUES($event_id, '$student_id', 1, 1, '$date')");

	if($sql){
		$date_format = Carbon::createFromFormat('Y-m-d', $date)->format('F d, Y');
		$audit->audit("Cleared student $student_id from his repercussions on $date_format!");
		$json['message'] = "Successfully cleared the student for this date and event!";
		$json['alert'] = "success";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}