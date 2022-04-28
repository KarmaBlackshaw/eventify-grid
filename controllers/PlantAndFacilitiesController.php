<?php

require_once dirname(__DIR__) . '/lib/init.php';
use Carbon\Carbon;
$audit = new Audit;

// Manage Venues
if(isset($_POST['load_table_manage_venues'])){
	$sql = $init->getData("SELECT v.venue_id, v.venue, v.capacity, v.price, v.image_url, names.fname, names.mname, names.lname 
		FROM venues v 
		LEFT JOIN bldg_coordinators b ON v.venue_id =  b.venue_id
		LEFT JOIN employees ON b.employees_id = employees.employees_id
		LEFT JOIN names ON employees.name_id = names.name_id
		WHERE v.removed = 0");

	for($i = 0; $i < count($sql); $i++){
		$sql[$i]->fullname = ($sql[$i]->fname == '' || $sql[$i]->fname == NULL) ? '<span class="text-danger">No bldg. coordinator yet</span>' : $sql[$i]->fname .' '. acronym($sql[$i]->mname) .' '. $sql[$i]->lname;
		$sql[$i]->venues_id = '<small class="font-italic font-weight-light">'. $sql[$i]->venue_id .'</small>';
		$sql[$i]->image_src =  '<img src="'. base_assets($sql[$i]->image_url) .'" alt="" class="avatar">';
		$sql[$i]->venue_employee = '
			<span class="d-block">'. $sql[$i]->venue .'</span>
			<small class="text-muted font-italic">'. $sql[$i]->fullname .'</small>
		';
		$sql[$i]->capacities = $sql[$i]->capacity . ' Persons';
		$sql[$i]->prices = '₱' . number_format($sql[$i]->price, 2);
		$sql[$i]->buttons = '
			<div class="btn-group">
				<button class="btn btn-primary btn-sm edit_table_manage_views" data-id="'. $sql[$i]->venue_id .'">Edit</button>
				<button class="btn bg-warning btn-sm remove_table_manage_views" data-id="'. $sql[$i]->venue_id .'" data-venue="'. $sql[$i]->venue .'">Remove</button>
			</div>
		';

		unset($sql[$i]->venue_id);
		unset($sql[$i]->image_url);
		unset($sql[$i]->capacity);
		unset($sql[$i]->price);
	}

	echo json_encode($sql);
}

if(isset($_POST['load_modal_edit_venues'])){
	$venue_id = $init->post('venue_id');

	$sql = $init->getData("SELECT v.venue_id, v.venue, v.capacity, v.price, v.image_url, names.fname, names.mname, names.lname 
		FROM venues v 
		LEFT JOIN bldg_coordinators b ON v.venue_id =  b.venue_id
		LEFT JOIN employees ON b.employees_id = employees.employees_id
		LEFT JOIN names ON employees.name_id = names.name_id
		WHERE v.venue_id = '$venue_id' AND v.removed = 0");

	$sql[0]->image_src = base_assets($sql[0]->image_url);
	$sql[0]->image_blur = base_assets('images/venues/white.jpg');
	
	echo json_encode($sql);
}

if(isset($_POST['edit_venue'])){
	$venue_id = $init->post('modal_venue_id');
	$name = $init->post('modal_venue_name');
	$capacity = $init->post('modal_venue_capacity');
	$price = $init->post('modal_venue_price');
	$image_bool = false;
	$json = array();

	$upload_errors = array(
	    0 => 'There is no error, the file uploaded with success',
	    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
	    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
	    3 => 'The uploaded file was only partially uploaded',
	    4 => 'No file was uploaded',
	    6 => 'Missing a temporary folder',
	    7 => 'Failed to write file to disk.',
	    8 => 'A PHP extension stopped the file upload.',
	);

	$image = $_FILES['modal_venue_change_image'];

	if($image['name'] !== ''){
		$image_name = $image['name'];
		$image_type = $image['type'];
		$image_tmp_name = $image['tmp_name'];
		$image_error = $image['error'];
		$image_size = $image['size'];

		if($image_error !== 0){
			$json['bool'] = false;
			$json['message'] = $upload_errors($image_error);
			$json['alert'] = "alert-danger";
		} else{
			$file_extension = explode('.', $image_name);

			if(!in_array($file_extension[1], array('jpg','jpeg','png'))){
				$json['bool'] = false;
				$json['message'] = "<b>Error!</b> File type should be .jpg, .jpeg, .png only!";
				$json['alert'] = "alert-danger";
			} else{
				$image_bool = true;

				$date = date('Y_m_d_h_i_');
				$new_name = $date . md5($date) . '.' . $file_extension[1];
				$image_url = 'images/venues/' . $new_name;
				$root = $_SERVER['DOCUMENT_ROOT'] . base_assets();
				$image_src = $root . $image_url;
			}
		}
	}

	if(!validate([$venue_id, $name, $capacity, $price])){
		$json['bool'] = false;
		$json['message'] = "<b>Error!</b> Cannot leave empty fields!";
		$json['alert'] = "alert-danger";
	} else{
		if($image_bool){
			$move = move_uploaded_file($image_tmp_name, $image_src);

			if($move){
				$sql = $init->query("UPDATE venues SET venue = '$name', capacity = '$capacity', price = '$price', image_url = '$image_url' WHERE venue_id = '$venue_id'");

				if($sql){
					$audit->audit("Updated a venue");
					$json['bool'] = true;
					$json['message'] = "Successfully updated venue!";
					$json['alert'] = "success";
				} else{
					$json['bool'] = false;
					$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
					$json['alert'] = "alert-danger";
				}
			} else{
				$json['bool'] = false;
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
				$json['alert'] = "alert-danger";
			}
		} else{
			$sql = $init->query("UPDATE venues SET venue = '$name', capacity = '$capacity', price = '$price' WHERE venue_id = '$venue_id'");

			if($sql){
				$audit->audit("Updated a venue");
				$json['bool'] = true;
				$json['message'] = "Successfully updated venue!";
				$json['alert'] = "success";
			} else{
				$json['bool'] = false;
				$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
				$json['alert'] = "alert-danger";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['modal_venue_remove'])){
	$venue_id = $init->post('modal_venue_remove');
	$json = array();

	$sql = $init->query("UPDATE venues SET removed = 1 WHERE venue_id = '$venue_id'");

	if($sql){
		$audit->audit("Removed a venue");
		$json['bool'] = true;
		$json['message'] = "Successfully removed venue!";
		$json['alert'] = "success";
	} else{
		$json['bool'] = false;
		$json['message'] = "<b>Error</b> Something went wrong! Please contact the administrator!";
		$json['alert'] = "alert-danger";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['file_venue_container_exist'])){
	$target = $init->post('file_venue_container_exist');
	$json = array();

	$file_directory = base_views('plant_and_facilities/venues/' . $target);
	$exists = file_exists($_SERVER['DOCUMENT_ROOT'] . $file_directory);

	if($exists){
		$json['bool'] = true;
		$json['url'] = $file_directory;
	} else{
		$json['bool'] = false;
	}

	echo json_encode($json);
}

if(isset($_POST['load_venue_charts'])){
	$year = $init->post('year');
	$month = $init->post('month');
	$json = [];

	$year = empty($init->post('year')) ? '0000' : $init->post('year');
	$month = (empty($init->post('month')) ? '' : sprintf('%02d', $init->post('month')));
	$date = "$year-$month";

	$sql_venue = $init->getData("SELECT * FROM venues WHERE removed = 0");

	foreach($sql_venue as $data){
		$json['venue'][] = $data->venue;
		$json['reserves'][] = $init->count("SELECT * FROM reservations r JOIN events e ON e.event_id = r.event_id WHERE r.venue_id = '$data->venue_id' AND e.date_of_use LIKE '%$date%'");
	}

	echo json_encode($json);
}

if(isset($_POST['load_table_venues_stats'])){
	$year = $init->post('year');
	$month = $init->post('month');
	$json = [];

	$year = empty($init->post('year')) ? '0000' : $init->post('year');
	$month = (empty($init->post('month')) ? '' : sprintf('%02d', $init->post('month')));
	$date = "$year-$month";

	$sql = $init->getData("SELECT * FROM venues");

	foreach($sql as $data){
		$data->count = $init->count("SELECT * 
			FROM reservations r JOIN events e ON e.event_id = r.event_id 
			WHERE r.venue_id = '$data->venue_id' 
			AND e.date_of_use LIKE '%$date%'");

		$bldg_sql = $init->getData("SELECT n.mname, n.lname, n.fname 
			FROM bldg_coordinators b 
			JOIN employees e ON e.employees_id = b.employees_id 
			JOIN names n ON n.name_id = e.name_id WHERE b.venue_id = '$data->venue_id'");

		if(!$bldg_sql){
			$data->name = "<span class=\"text-danger\">No bldg. coordinator yet.</span>";
		} else{
			$data->name = formatName($bldg_sql[0]->fname, $bldg_sql[0]->mname, $bldg_sql[0]->lname);
		}
		
		unset($data->venue_id);
		unset($data->capacity);
		unset($data->price);
		unset($data->image_url);
		unset($data->created_at);
		unset($data->updated_at);
		unset($data->removed);
	}

	echo json_encode($sql);

}

// Venues
if(isset($_POST['load_venue_cards'])){
	$sql = $init->getData("SELECT v.venue_id, v.venue, v.capacity, v.price, v.image_url, names.fname, names.mname, names.lname 
		FROM venues v 
		LEFT JOIN bldg_coordinators b ON v.venue_id =  b.venue_id
		LEFT JOIN employees ON b.employees_id = employees.employees_id
		LEFT JOIN names ON employees.name_id = names.name_id
		WHERE v.removed = 0");

	for($i = 0; $i < count($sql); $i++){
		$sql[$i]->image_src = base_assets($sql[$i]->image_url);
		$sql[$i]->coordinator = ($sql[$i]->fname == '' || $sql[$i]->fname == NULL) ? '' : $sql[$i]->fname . ' ' . acronym($sql[$i]->mname) .' '. $sql[$i]->lname;
		$sql[$i]->position = ($sql[$i]->fname == '' || $sql[$i]->fname == NULL) ? '<span class="text-danger">No bldg. coordinator yet!</span>' : 'Bldg. Coordinator';
	}

	echo json_encode($sql);
}

// Trash
if(isset($_POST['load_trash_venues_table'])){
	$sql = $init->getData("SELECT v.venue_id, v.venue, v.capacity, v.price, v.image_url, names.fname, names.mname, names.lname 
		FROM venues v 
		LEFT JOIN bldg_coordinators b ON v.venue_id =  b.venue_id
		LEFT JOIN employees ON b.employees_id = employees.employees_id
		LEFT JOIN names ON employees.name_id = names.name_id
		WHERE v.removed = 1");

	for($i = 0; $i < count($sql); $i++){
		$sql[$i]->fullname = ($sql[$i]->fname == '' || $sql[$i]->fname == NULL) ? '<span class="text-danger">No bldg. coordinator yet</span>' : $sql[$i]->fname .' '. acronym($sql[$i]->mname) .' '. $sql[$i]->lname;
		$sql[$i]->venues_id = '<small class="font-italic font-weight-light">'. $sql[$i]->venue_id .'</small>';
		$sql[$i]->image_src =  '<img src="'. base_assets($sql[$i]->image_url) .'" alt="" class="avatar">';
		$sql[$i]->venue_employee = '
			<span class="d-block">'. $sql[$i]->venue .'</span>
			<small class="text-muted font-italic">'. $sql[$i]->fullname .'</small>
		';
		$sql[$i]->capacities = $sql[$i]->capacity . ' Persons';
		$sql[$i]->prices = '₱' . number_format($sql[$i]->price, 2);
		$sql[$i]->buttons = '
			<div class="btn-group">
				<button class="btn btn-success btn-sm restore_venues_trash" data-id="'. $sql[$i]->venue_id .'" data-venue="'. $sql[$i]->venue .'">Restore</button>
			</div>
		';

		unset($sql[$i]->venue_id);
		unset($sql[$i]->image_url);
		unset($sql[$i]->capacity);
		unset($sql[$i]->price);
	}
	
	echo json_encode($sql);
}

if(isset($_POST['restore_venues'])){
	$venue_id = $init->post('restore_venues');

	$sql = $init->query("UPDATE venues SET removed = 0 WHERE venue_id = '$venue_id'");

	if($sql){
		$audit->audit("Restored a venue");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully restored venue!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Facilities
if(isset($_POST['load_modal_facility_type'])){
	$sql = $init->getData("SELECT facility_id, facility FROM facilities WHERE removed = 0");

	echo json_encode($sql);
}

if(isset($_POST['load_facilities_cards'])){
	$sql = $init->getData("SELECT items.facility_item_id, items.item, items.quantity, items.img_url, facilities.facility
			FROM facility_items items
			JOIN facilities ON facilities.facility_id = items.facility_id 
			WHERE facilities.removed = 0 AND items.removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->img_src = assets($sql[$i]->img_url);
		$sql[$i]->img_avatar = '<img class="avatar" src="'. assets($sql[$i]->img_url) .'" alt="">';
		$sql[$i]->formatted_id = "<small>". $sql[$i]->facility_item_id ."</small>";
		$sql[$i]->facility_item_id = $sql[$i]->facility_item_id;
		$sql[$i]->quantity = $sql[$i]->quantity . " pcs.";
		$sql[$i]->item = "<strong>". $sql[$i]->item ."</strong>";

		$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:" class="dropdown-item facility_items_edit" data-item_id="'. $sql[$i]->facility_item_id .'"><i class="dropdown-icon fe fe-edit"></i> Edit </a>
				<a href="javascript:" class="dropdown-item facility_items_remove" data-item_id="'. $sql[$i]->facility_item_id .'" data-item="'. $sql[$i]->item .'"><i class="dropdown-icon fe fe-trash"></i> Remove </a>
			</div>
			</div>';
	}

	echo json_encode($sql);
}

if(isset($_POST['load_modal_edit_facility'])){
	$facility_item_id = $init->post('load_modal_edit_facility');

	$sql = $init->getData("SELECT items.facility_item_id, items.item, items.quantity, items.img_url, facilities.facility_id
			FROM facility_items items
			JOIN facilities ON facilities.facility_id = items.facility_id 
			WHERE facilities.removed = 0 AND items.facility_item_id = '$facility_item_id'");

	$sql[0]->img_src = assets($sql[0]->img_url);

	echo json_encode($sql);
}

if(isset($_POST['modal_facility_item_id'])){
	$item_id = $init->post('modal_facility_item_id');
	$item = $init->post('modal_facility_item');
	$facility = $init->post('modal_facility_type');
	$quantity = $init->post('modal_facility_quantity');
	$image = $_FILES['modal_facility_change_image'];

	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	$json['alert'] = "danger";

	$upload_errors = array(
	    0 => 'There is no error, the file uploaded with success',
	    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
	    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
	    3 => 'The uploaded file was only partially uploaded',
	    4 => 'No file was uploaded',
	    6 => 'Missing a temporary folder',
	    7 => 'Failed to write file to disk.',
	    8 => 'A PHP extension stopped the file upload.',
	);

	$validate = check_err($_POST);

	if(!empty($validate)){
		$json['message'] = $validate;
	} else{
		$image_name = $image['name'];
		$image_type = $image['type'];
		$image_tmp_name = $image['tmp_name'];
		$image_error = $image['error'];
		$image_size = $image['size'];

		if(!empty($image_name)){
			if($image_error > 0){
				$json['message'] = $upload_errors[$image_error];
			} else{
				$file_extension = explode('.', $image_name);

				if(!in_array(end($file_extension), array('jpg','jpeg','png'))){
					$json['message'] = "<b>Error!</b> File type is limited to .jpg, .jpeg, .png only!";
				} else{
					$date = date('Y_m_d_h_i_');
					$new_name = $date . md5($date) . '.' . $file_extension[1];
					$image_url = 'images/plant_and_facilities/' . $new_name;
					$root = $_SERVER['DOCUMENT_ROOT'] . base_assets();
					$image_src = $root . $image_url;

					$move = move_uploaded_file($image_tmp_name, $image_src);

					if($move){
						$sql = $init->query("UPDATE facility_items SET item = '$item', facility_id = '$facility', quantity = '$quantity', img_url = '$image_url' WHERE facility_item_id = '$item_id'");

						if($sql){
							$audit->audit("Updated a facility item");
							$json['message'] = "Successfully updated facility item!";
							$json['alert'] = "success";
						}
					}
				}
			}
		} else{
			$sql = $init->query("UPDATE facility_items SET item = '$item', facility_id = '$facility', quantity = '$quantity' WHERE facility_item_id = '$item_id'");

			if($sql){
				$audit->audit("Updated a facility item");
				$json['message'] = "Successfully updated facility item!";
				$json['alert'] = "success";
			}
		}
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['remove_facility_item'])){
	$item_id = $init->post('remove_facility_item');
	$json = array();

	$sql = $init->query("UPDATE facility_items SET removed = 1 WHERE facility_item_id = '$item_id'");

	if($sql){
		$audit->audit("Removed a facility item");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully removed facility item!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['add_item'])){
	$plant = new Plant;

	$name = $init->post('add_item_name');
	$type = $init->post('add_item_type');
	$qty = $init->post('add_item_qty');
	$image = $_FILES['add_item_image'];

	$_POST['image_name'] = $image['name'];
	$validate = check_err($_POST);

	$json['alert'] = 'danger';
	$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";

	$upload_errors = array(
	    0 => 'There is no error, the file uploaded with success',
	    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
	    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
	    3 => 'The uploaded file was only partially uploaded',
	    4 => 'No file was uploaded',
	    6 => 'Missing a temporary folder',
	    7 => 'Failed to write file to disk.',
	    8 => 'A PHP extension stopped the file upload.',
	);

	if(empty(count($validate)) && !empty($image['name'])){
		$image_name = $image['name'];
		$image_type = $image['type'];
		$image_tmp_name = $image['tmp_name'];
		$image_error = $image['error'];
		$image_size = $image['size'];
		

		if($image_error > 0){
			$json['message'] = $upload_errors[$image_error];
			$json['alert'] = "danger";
		} else{
			$file_extension = explode('.', $image_name);

			if(!in_array(end($file_extension), array('jpg','jpeg','png'))){
				$json['message'] = "<b>Error!</b> File type invalid!";
			} else{
				$date = date('Y_m_d_h_i_');
				$new_name = $date . md5($date) . '.' . end($file_extension);
				$image_url = 'images/plant_and_facilities/' . $new_name;
				$root = $_SERVER['DOCUMENT_ROOT'] . base_assets();
				$image_src = $root . $image_url;

				$move = move_uploaded_file($image_tmp_name, $image_src);

				if($move){
					if($plant->facilityItemExists($name)){
						$json['message'] = "<b>Error!</b> Item already exists in the database!";
					} else{
						$sql = $init->query("INSERT INTO facility_items(item, quantity, facility_id, img_url) VALUES('$name', '$qty', '$type', '$image_url')");

						if($sql){
							$audit->audit("Added a new facility item");
							$json['alert'] = "success";
							$json['message'] = "Successfully added item to the database!";
						}
					}
				}
			}
		}
	} else{
		$json['message'] = $validate;
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Facility Types
if(isset($_POST['load_table_facilities_manage_type'])){
	$sql = $init->getData("SELECT facility_id, facility, created_at, updated_at FROM facilities WHERE removed = 0");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->formatted_id = "<small>". $sql[$i]->facility_id ."</small>";
		$sql[$i]->formatted_facility = "<b>". $sql[$i]->facility ."</b>";
		$sql[$i]->created_at = Carbon::createFromFormat('Y-m-d H:i:s', $sql[$i]->created_at)->toFormattedDateString();
		$sql[$i]->updated_at = $sql[$i]->updated_at == 0 ? "<small><i>Not yet updated</i></small>" : Carbon::createFromFormat('Y-m-d H:i:s', $sql[$i]->updated_at)->diffForHumans();

		$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:" class="dropdown-item call_modal_edit_facility_type" data-facility_id="'. $sql[$i]->facility_id .'" data-facility="'. $sql[$i]->facility .'"><i class="dropdown-icon fe fe-edit"></i> Edit </a>
				<a href="javascript:" class="dropdown-item call_modal_remove_facility_type" data-facility_id="'. $sql[$i]->facility_id .'" data-facility="'. $sql[$i]->facility .'"><i class="dropdown-icon fe fe-trash"></i> Remove </a>
			</div>
			</div>';
	}

	echo json_encode($sql);
}

if(isset($_POST['edit_facility_type'])){
	$facility_id = $init->post('edit_facility_type');
	$facility = $init->post('facility');

	$sql = $init->query("UPDATE facilities SET facility = '$facility' WHERE facility_id = '$facility_id'");

	if($sql){
		$audit->audit("Updated a facility type");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully updated facility type!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

if(isset($_POST['remove_facility_type'])){
	$facility_id = $init->post('remove_facility_type');

	$sql = $init->query("UPDATE facilities SET removed = 1 WHERE facility_id = '$facility_id'");

	if($sql){
		$audit->audit("Removed a facility type");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully updated facility type!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Facility Trash
if(isset($_POST['load_trash_item'])){
	$sql = $init->getData("SELECT i.facility_item_id, i.item, f.facility, i.updated_at FROM facility_items i JOIN facilities f ON i.facility_id = f.facility_id WHERE i.removed = 1");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->formatted_id = "<small>". $sql[$i]->facility_item_id ."</small>";
		$sql[$i]->deleted_at = Carbon::createFromFormat('Y-m-d H:i:s', $sql[$i]->updated_at)->toFormattedDateString();

		$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:" class="dropdown-item call_modal_restore_item" data-item_id="'. $sql[$i]->facility_item_id .'" data-item="'. $sql[$i]->item .'"><i class="fe fe-arrow-up"></i> Restore </a>
			</div>
			</div>';

		unset($sql[$i]->updated_at);
	}

	echo json_encode($sql);
}

if(isset($_POST['restore_item'])){
	$item_id = $init->post('restore_item');

	$sql = $init->query("UPDATE facility_items SET removed = 0 WHERE facility_item_id = '$item_id'");

	if($sql){
		$audit->audit("Restored a facility item");
		$json['bool'] = true;
		$json['alert'] = 'success';
		$json['message'] = "Successfully restored facility item!";
	} else{
		$json['bool'] = false;
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}


if(isset($_POST['load_trash_facility'])){
	$sql = $init->getData("SELECT f.facility_id, f.facility, f.updated_at FROM facilities f WHERE f.removed = 1");

	$count = count($sql);

	for($i = 0; $i < $count; $i++){
		$sql[$i]->formatted_id = "<small>". $sql[$i]->facility_id ."</small>";
		$sql[$i]->deleted_at = Carbon::createFromFormat('Y-m-d H:i:s', $sql[$i]->updated_at)->toFormattedDateString();

		$sql[$i]->options = '<div class="item-action dropdown">
			<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="javascript:" class="dropdown-item call_modal_restore_facility" data-facility_id="'. $sql[$i]->facility_id .'" data-facility="'. $sql[$i]->facility .'"><i class="fe fe-arrow-up"></i> Restore </a>
			</div>
			</div>';

		unset($sql[$i]->updated_at);
	}

	echo json_encode($sql);
}

if(isset($_POST['restore_facility'])){
	$facility_id = $init->post('restore_facility');

	$sql = $init->query("UPDATE facilities SET removed = 0 WHERE facility_id = '$facility_id'");

	if($sql){
		$audit->audit("Restored a facility");
		$json['alert'] = 'success';
		$json['message'] = "Successfully restored facility!";
	} else{
		$json['alert'] = 'danger';
		$json['message'] = "<b>Error!</b> Something went wrong! Please contact the administrator!";
	}

	$json['error'] = $init->error();

	echo json_encode($json);
}

// Events
if(isset($_POST['load_table_events_approval'])){
	$plant = new Plant();
	$ssc = new SSC();

	$sql = $plant->getEventsApproval();

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

if(isset($_POST['approve_event'])){
	$plant = new Plant();
	$ssc = new SSC();
	$event_id = $init->post('approve_event');

	$sql = $plant->approveEvent($event_id);

	if($sql){
		$audit->audit("Approved an event");

		$ssc->notifySSC("Good day officer! Your event has been successfully approved by the Plant and Facilities Director!");

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
	$plant = new Plant();
	$event_id = $init->post('disapprove_event');

	$sql = $plant->disapproveEvent($event_id);

	if($sql){
		$audit->audit("Disapproved an event");

		$ssc->notifySSC("Good day officer! We are sorry to inform you that your event has been disapproved by the Plant and Facilities Director!");

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

if(isset($_POST['load_events_manage'])){
	$plant = new Plant();
	$ssc = new SSC();

	$sql = $plant->getEvents();

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

		$self_status = $plant->isPlantApproved($data->event_id);

		if($self_status){ // Approve
			$data->event_formatted = '<span class="no-wrap" title="Approved"><i class="fas fa-circle fa-xs text-success font-06 mr-1 pb-1"></i>'. $data->event . '</span>';
			$data->self_status = 'self:Approved';
		} elseif(is_null($self_status)){ // Idle
			$data->event_formatted = '<span class="no-wrap" title="Idle"><i class="fas fa-circle fa-xs text-secondary font-06 mr-1 pb-1"></i>'. $data->event . '</span>';
			$data->self_status = 'self:Idle';
		} else{ // Disapproved
			$data->event_formatted = '<span class="no-wrap" title="Disapproved"><i class="fas fa-circle fa-xs text-danger font-06 mr-1 pb-1"></i>'. $data->event . '</span>';
			$data->self_status = 'self:Disapproved';
		}

		$data->status_badge = $ssc->getStatusBadge($data->status_id);

		$data->event_reservation_link = base_views('plant_and_facilities/events/pdf_venue_reservation', 'e=' . $data->event_id);

		$data->options = '
			<div class="item-action dropdown">
			  <a href="javascript:" data-toggle="dropdown" class="icon"><i class="fe fe-settings text-dark"></i></a>
			  <div class="dropdown-menu dropdown-menu-right">
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