<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;

if(isset($_POST['load_events_approval'])){
	$bldg = new Bldg();
	$ssc = new SSC();
	$sql = $bldg->getEventsForApproval();

	foreach($sql as $data){
		$data->hash = md5($data->event_id);
		$date_raw = json_decode($data->date_of_use);
		$time_raw = explode('%', $data->inclusive_time);

		// Dates
		$ssc->updateEventStatus(reset($date_raw), end($date_raw), $data->event_id);
		$date_start = Carbon::createFromFormat('Y-m-d', reset($date_raw))->toFormattedDateString();
		$date_end = Carbon::createFromFormat('Y-m-d', end($date_raw))->toFormattedDateString();
		$data->date = "$date_start - $date_end";

		// Time
		$time_start = Carbon::createFromFormat('G:i', reset($time_raw))->format('g:iA');
		$time_end = Carbon::createFromFormat('G:i', end($time_raw))->format('g:iA');
		$data->time = "$time_start - $time_end";

		$data->event_formatted = '<span class="no-wrap" title="Approved"><i class="fas fa-circle fa-xs text-secondary font-06 mr-1 pb-1"></i>'. $data->event . '</span>';

		$data->status_badge = '<span class="badge hvr-grow bg-blue p-1 no-highlight d-block m-1">Yow</span>';

		$event_reservation_link = base_views('bldg_coordinator/bldg/pdf_venue_reservation', 'e=' . $data->event_id);

		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
			    <a href="javascript:" class="dropdown-item call_modal_approve" data-event_id="'. $data->event_id .'"><i class="dropdown-icon  fe fe-thumbs-up"></i> Approve </a>
			    <a href="javascript:" class="dropdown-item call_modal_disapprove" data-event_id="'. $data->event_id .'" data-event="'. $data->event .'"><i class="dropdown-icon  fe fe-thumbs-down"></i> Disapprove </a>
			    <a href="'. $event_reservation_link .'" target="_blank" class="dropdown-item download_reservation"><i class="dropdown-icon  fe fe-download"></i> Download Reservation </a>
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
	}

	echo json_encode($sql);
}

if(isset($_POST['get_event_information'])){
	$event_id = $init->post('get_event_information');

	$bldg = new Bldg();
	$ssc = new SSC();

	$sql = $bldg->getEventInfo($event_id);
	
	// Dates
	$date_raw = json_decode($sql[0]->date_of_use);
	$date_start = Carbon::createFromFormat('Y-m-d', reset($date_raw))->toFormattedDateString();
	$date_end = Carbon::createFromFormat('Y-m-d', end($date_raw))->toFormattedDateString();
	$sql[0]->date = "$date_start - $date_end";

	// Time
	$time_raw = explode('%', $sql[0]->inclusive_time);
	$time_start = Carbon::createFromFormat('G:i', reset($time_raw))->format('g:iA');
	$time_end = Carbon::createFromFormat('G:i', end($time_raw))->format('g:iA');
	$sql[0]->time = "$time_start - $time_end";

	// Items
	$item_id = $sql[0]->facility_item_id;
	$explode_item = explode(', ', $item_id);
	$items = [];
	$facility = [];

	// Quantity
	$quantity = $sql[0]->item_quantity;
	$explode_qty = explode(', ', $quantity);
	$sql[0]->quantity = $explode_qty;

	foreach($explode_item as $data){
		$sql_items = $init->getData("SELECT i.item, f.facility FROM facility_items i JOIN facilities f ON f.facility_id = i.facility_id  WHERE i.facility_item_id = $data");
		$items[] = $sql_items[0]->item;
		$facility[] = $sql_items[0]->facility;
	}

	$sql[0]->items = $items;
	$sql[0]->facility = $facility;
	$sql[0]->recipients = $ssc->getRecipients($sql[0]->recipient_department, $sql[0]->recipient_year_level);

	unset($sql[0]->item_id);
	unset($sql[0]->facility_item_id);
	unset($sql[0]->item_quantity);
	unset($sql[0]->date_of_use);
	unset($sql[0]->inclusive_time);	
	unset($sql[0]->date_start);
	unset($sql[0]->date_end);
	unset($sql[0]->time_start);
	unset($sql[0]->time_end);
	unset($sql[0]->date_raw);
	unset($sql[0]->time_raw);
	unset($sql[0]->attendance);
	unset($sql[0]->status_id);
	unset($sql[0]->event_img);
	unset($sql[0]->event_type_id);
	unset($sql[0]->recipient_department);
	unset($sql[0]->recipient_year_level);

	echo json_encode($sql);
}

if(isset($_POST['approve_event'])){
	$ssc = new SSC;
	
	$event_id = $init->post('approve_event');
	$json = [];
	$sql = $init->query("UPDATE approvals SET approved = 1 WHERE event_id = '$event_id' AND account_id = {$_SESSION['account_id']} LIMIT 1");


	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = 'danger';

	if($sql){
		$audit->audit("Approved an event");

		SSC::sms([$ssc->getPlantAccountID()->user_contact], 'A new event has been proposed by the Supreme Student Council. Please log in to your account for more information!');
		$ssc->notifySSC("Good day officer! Your event has been successfully approved by the Building Coordinator!");

		$json['message'] = "Successfully approved event!";
		$json['alert'] = "success";
		$json['bool'] = true;
	}

	echo json_encode($json);
}

if(isset($_POST['disapprove_event'])){
	$ssc = new SSC;

	$event_id = $init->post('disapprove_event');
	$json = [];
	$sql = $init->query("UPDATE approvals SET approved = 0 WHERE event_id = '$event_id' AND account_id = {$_SESSION['account_id']} LIMIT 1");


	$json['bool'] = false;
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = 'danger';

	if($sql){
		$audit->audit("Disapproved an event");

		$ssc->notifySSC("Good day officer! We are sorry to inform you that your event has been disapproved by the Building Coordinator!");

		$json['message'] = "Successfully disapproved event!";
		$json['alert'] = "success";
		$json['bool'] = true;
	}

	echo json_encode($json);
}

if(isset($_POST['load_events'])){
	$bldg = new Bldg();
	$ssc = new SSC();

	$sql = $bldg->getEvents();

	foreach($sql as $data){

		$data->hash = md5($data->event_id);
		$date_raw = json_decode($data->date_of_use);
		$time_raw = explode('%', $data->inclusive_time);

		// Dates
		$date_start = Carbon::createFromFormat('Y-m-d', reset($date_raw))->toFormattedDateString();
		$date_end = Carbon::createFromFormat('Y-m-d', end($date_raw))->toFormattedDateString();
		$data->date = "$date_start - $date_end";

		$ssc->updateEventStatus(reset($date_raw), end($date_raw), $data->event_id);

		// Time
		$time_start = Carbon::createFromFormat('G:i', reset($time_raw))->format('g:iA');
		$time_end = Carbon::createFromFormat('G:i', end($time_raw))->format('g:iA');
		$data->time = "$time_start - $time_end";

		// Link
		$event_reservation_link = base_views('bldg_coordinator/bldg/pdf_venue_reservation', 'e=' . $data->event_id);

		$data->status_badge = $ssc->getStatusBadge($data->status_id, $data->status);

		$self = $bldg->checkSelfApproval($data->event_id);

		$data->self_status = "self:idle";
		$data->event_formatted = '<span class="no-wrap" title="Idle"><i class="fas fa-circle fa-xs text-secondary font-06 mr-1 pb-1"></i>'. $data->event . '</span>';
		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
			    <a href="'. $event_reservation_link .'" target="_blank" class="dropdown-item download_reservation"><i class="dropdown-icon  fe fe-download"></i> Download Reservation </a>
			  </div>
			</div>
		';

		unset($data->date_of_use);
		unset($data->inclusive_time);
		unset($data->facility_item_id);
		unset($data->attendance);
		unset($data->status);
		unset($data->status_id);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_venues'])){
	$bldg = new Bldg();

	$sql = $bldg->getMyBuildings();

	foreach($sql as $data){
		$data->image = '<img src="'. assets($data->image_url) .'" class="avatar" alt="">';
		$data->capacity = $data->capacity . " people";
		$data->price = "P" . number_format($data->price, 2);
		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
			    <a href="javascript:" class="dropdown-item call_modal_edit_venue" data-venue_id="'. $data->venue_id .'"><i class="dropdown-icon  fe fe-edit"></i> Edit </a>
			  </div>
			</div>
		';

		unset($data->image_url);
		unset($data->created_at);
		unset($data->updated_at);
		unset($data->removed);
	}

	echo json_encode($sql);
}

if(isset($_POST['call_modal_edit_venue'])){
	$venue_id = $init->post('call_modal_edit_venue');

	$bldg = new Bldg();

	$sql = $bldg->getBuildingInfo($venue_id);

	$sql[0]->image_url = assets($sql[0]->image_url);

	unset($sql[0]->created_at);
	unset($sql[0]->updated_at);
	unset($sql[0]->removed);

	echo json_encode($sql);
}

if(isset($_POST['getMonthsOfYear'])){
	$bldg = new Bldg();
	$year = $init->post('getMonthsOfYear');

	$sql = $bldg->getMonths($year);
	$months = [];

	foreach($sql as $data){
		$months[] = Carbon::createFromFormat('m', $data->months)->format('F');
	}

	echo json_encode($months);
}

if(isset($_POST['chartGetStats'])){
	$bldg = new Bldg();
	$year = $init->post('year');
	$month = (empty($init->post('month')) ? '' : sprintf('%02d', $init->post('month')));
	$date = "$year-$month";

	$json = [];

	$sql_bldg = $bldg->getMyBuildings();

	foreach($sql_bldg as $data){
		$json['venue_id'][] = $data->venue_id;
		$json['venue'][] = $data->venue;
	}

	if(!empty($json['venue_id'])){
		foreach($json['venue_id'] as $data){
			$sql = $init->getData("SELECT count(*) x FROM reservations WHERE venue_id = $data AND created_at LIKE '%$date%'");
			$json['reservations'][] = $sql[0]->x;
		}
	}
	
	echo json_encode($json);
}