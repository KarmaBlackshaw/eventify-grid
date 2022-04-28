<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$osa = new StudentAffairs();
$ssc = new SSC();
$audit = new Audit;

if(isset($_POST['load_events_approval'])){
	$sql = $osa->getEventsApproval();

	foreach($sql as $data){
		$data->hash = md5($data->event_id);
		$date_raw = json_decode($data->date_of_use);
		$time_raw = explode('%', $data->inclusive_time);

		// Dates
		$ssc->updateEventStatus(reset($date_raw), end($date_raw), $data->event_id);
		$first_date = Carbon::createFromFormat('Y-m-d', reset($date_raw));
		$end_date = Carbon::createFromFormat('Y-m-d', end($date_raw));
		$data->date = formatDate($first_date, $end_date);

		// Time
		$time_start = Carbon::createFromFormat('G:i', reset($time_raw))->format('g:iA');
		$time_end = Carbon::createFromFormat('G:i', end($time_raw))->format('g:iA');
		$data->time = "$time_start - $time_end";

		$data->event_formatted = "<b>$data->event</b>";

		$data->event_reservation_link = base_views('plant_and_facilities/events/pdf_venue_reservation', 'e=' . $data->event_id);
		// $data->event_proposal_link = base_views('student_affairs/events/pdf_events', 'e=' . $data->event_id);

		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
			    <a href="javascript:" class="dropdown-item call_modal_approve" data-event_id="'. $data->event_id .'"><i class="dropdown-icon  fe fe-thumbs-up"></i> Approve </a>
			    <a href="javascript:" class="dropdown-item call_modal_disapprove" data-event_id="'. $data->event_id .'" data-event="'. $data->event_formatted .'"><i class="dropdown-icon  fe fe-thumbs-down"></i> Disapprove </a>
			    <a href="'. $data->event_reservation_link .'" target="_blank" class="dropdown-item call_modal_approve"><i class="dropdown-icon  fe fe-file"></i> Reservation Form </a>
			  </div>
			</div>
		';

		unset($data->date_of_use);
		unset($data->inclusive_time);
		unset($data->date_start);
		unset($data->date_end);
		unset($data->time_start);
		unset($data->time_end);
		unset($data->date_raw);
		unset($data->time_raw);
		unset($data->attendance);
		unset($data->status_id);
		unset($data->event_img);
		unset($data->event_type_id);
		unset($data->created_at);
		unset($data->removed);
		unset($data->updated_at);
		unset($data->account_id);
		unset($data->capacity);
		unset($data->facility_item_id);
		unset($data->image_url);
		unset($data->item_quantity);
		unset($data->price);
		unset($data->recipient_department);
		unset($data->recipient_year_level);
		unset($data->reservation_id);
		unset($data->venue_id);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_event_info_for_approval'])){
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
		$sql_item = $init->getData("SELECT item FROM facility_items WHERE facility_item_id = {$exploded_items[$i]}");
		$facility_item_arr[] = $sql_item[0]->item;
		$facility_item_qty[] = $exploded_qty[$i] . ' pcs';
	}
	// End Facility

	$sql[0]->controllers = base_views('student_affairs/events/pdf_events', 'e=' . $event_id);
	// Wrap things
	foreach($sql as $data){
		$data->facility_item_arr = $facility_item_arr;
		$data->facility_item_qty = $facility_item_qty;
		$data->recipient = $recipient;
		$data->composer = $ssc->getFormattedName($sql[0]->account_id);
		$data->adviser_name = $ssc->getSscAdviserName();
		$data->date_of_usage = $start . ' - ' . $end;
		$data->time = $time_start . ' - ' . $time_end;
		// $data->controllers = base_views('ssc/events/pdf_events', 'e=' . $event_id);
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

if(isset($_POST['approve_event'])){
	$event_id = $init->post('approve_event');

	$sql = $osa->approveEvent($event_id);

	if($sql){
		$audit->audit("Approved an event");

		$ssc->notifySSC("Good day officer! Your event has been successfully approved by the Office of Student Affairs Director!");

		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully approved event!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	if($ssc->isApproved($event_id)){
		$ssc->notifySSC("Good day officer! Your event has been successfully approved!");
		$sql = SSC::sms($ssc->getEventRecipientNumbers($event_id), "Good day student! We have successfully proposed a new event! Please log in to your account for more information. Don't forget to give your reaction ;)");
	}

	echo json_encode($json);
}

if(isset($_POST['disapprove_event'])){
	$event_id = $init->post('disapprove_event');

	$sql = $osa->disapproveEvent($event_id);

	if($sql){
		$audit->audit("Disapproved an event");

		$ssc->notifySSC("Good day officer! We are sorry to inform you that your event has been disapproved by the Office of Students Affair Director!");

		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully disapproved event!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	echo json_encode($json);
}

if(isset($_POST['load_events'])){
	$plant = new Plant();
	$ssc = new SSC();

	$sql = $osa->getEvents();

	foreach($sql as $data){
		$data->hash = md5($data->event_id);
		$date_raw = json_decode($data->date_of_use);
		$time_raw = explode('%', $data->inclusive_time);

		$ssc->updateEventStatus(reset($date_raw), end($date_raw), $data->event_id);
		
		// Dates
		$ssc->updateEventStatus(reset($date_raw), end($date_raw), $data->event_id);
		$first_date = Carbon::createFromFormat('Y-m-d', reset($date_raw));
		$end_date = Carbon::createFromFormat('Y-m-d', end($date_raw));
		$data->date = formatDate($first_date, $end_date);

		// Time
		$time_start = Carbon::createFromFormat('G:i', reset($time_raw))->format('g:iA');
		$time_end = Carbon::createFromFormat('G:i', end($time_raw))->format('g:iA');
		$data->time = "$time_start - $time_end";

		$data->event_formatted = "<b>$data->event</b>";

		$data->status_badge = $ssc->getStatusBadge($data->status_id);

		$data->event_reservation_link = base_views('plant_and_facilities/events/pdf_venue_reservation', 'e=' . $data->event_id);
		$data->event_proposal_link = base_views('student_affairs/events/pdf_events', 'e=' . $data->event_id);

		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
			    <a href="'. $data->event_reservation_link .'" target="_blank" class="dropdown-item call_modal_approve"><i class="dropdown-icon  fe fe-file"></i> Reservation Form </a>
			    <a href="'. $data->event_proposal_link .'" target="_blank" class="dropdown-item call_modal_approve"><i class="dropdown-icon  fe fe-file"></i> Proposal </a>
			  </div>
			</div>
		';

		unset($data->date_of_use);
		unset($data->inclusive_time);
		unset($data->date_start);
		unset($data->date_end);
		unset($data->time_start);
		unset($data->time_end);
		unset($data->date_raw);
		unset($data->time_raw);
		unset($data->attendance);
		unset($data->status_id);
		unset($data->event_img);
		unset($data->event_type_id);
		unset($data->created_at);
		unset($data->removed);
		unset($data->updated_at);
		unset($data->account_id);
		unset($data->capacity);
		unset($data->facility_item_id);
		unset($data->image_url);
		unset($data->item_quantity);
		unset($data->price);
		unset($data->recipient_department);
		unset($data->recipient_year_level);
		unset($data->reservation_id);
		unset($data->venue_id);
	}

	echo json_encode($sql);
}