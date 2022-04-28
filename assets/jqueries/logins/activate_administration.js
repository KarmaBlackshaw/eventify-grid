$(document).ready(function(){
	// load_administration_position();
	load_administration_office();
})

function load_administration_office(){
	var select = $('#administration_office');

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_administration_office : 1},
		dataType : 'JSON'
	})
	.done(function(e){
		for(i in e){
			var office_id = e[i].office_id,
				office = e[i].office;

			select.append($('<option>', {
				value : office_id,
				text : office
			}))
		}
	})
}

$('#administration_office').on('change', function(){
	var office_id = $(this).val();
	var select = $('#administration_position');
	select.find('option').not(':first').remove();

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_administration_position : office_id},
		dataType : 'JSON'
	})
	.done(function(e){
		for(i in e){
			var position_id = e[i].position_id,
				position = e[i].position;

			select.append($('<option>', {
				value : position_id,
				text : position
			}))
		}
	})
})

// validate_administration
$('#activate_administration').on('input', function(){
	var office_id = $('#administration_office').val(),
		fname = $('#administration_fname').val(),
		mname = $('#administration_mname').val(),
		lname = $('#administration_lname').val(),
		position_id = $('#administration_position').val(),
		employee_id = $('#administration_employee_id').val(),
		activation_code = $('#administration_activation_code').val(),
		username = $('#administration_username').val(),
		password = $('#administration_password').val(),
		btn_activate = $('#administration_btn_activate');

	if(validate([office_id, fname, mname, lname, position_id, employee_id, activation_code, username, password])){
		$.ajax({
			url : controllers('ActivatesController'),
			method : 'POST',
			data : {
				validate_administration : 1,
				office_id : office_id,
				fname : fname,
				mname : mname,
				lname : lname,
				position_id : position_id,
				employee_id : employee_id,
				activation_code : activation_code,
				username : username,
				password : password
			},
			dataType : 'JSON'
		})
		.done(function(e){
			if(e.bool == true){
				$('#alert_container').addClass(e.alert).removeClass('hidden alert-danger');
				$('#alert_message').html(e.message);
				$('#administration_btn_activate').prop('disabled', false).removeClass('btn-muted').addClass('btn-success');
			} else{
				$('#alert_container').addClass(e.alert).removeClass('hidden alert-success');
				$('#alert_message').html(e.message);
				$('#administration_btn_activate').prop('disabled', true).addClass('btn-muted').removeClass('btn-success');
			}
		})
		
	} else{
		$('#alert_container').removeClass('alert-success alert-danger').addClass('hidden');
		$('#alert_message').html('');
		$('#administration_btn_activate').prop('disabled', true).addClass('btn-muted').removeClass('btn-success');
	}
})

// activate_administration
$('#administration_btn_activate').on('click', function(e){
	e.preventDefault();
	var office_id = $('#administration_office').val(),
		fname = $('#administration_fname').val(),
		mname = $('#administration_mname').val(),
		lname = $('#administration_lname').val(),
		position_id = $('#administration_position').val(),
		employee_id = $('#administration_employee_id').val(),
		activation_code = $('#administration_activation_code').val(),
		username = $('#administration_username').val(),
		password = $('#administration_password').val(),
		btn_activate = $('#administration_btn_activate');

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {
			activate_administration : 1,
			office_id : office_id,
			fname : fname,
			mname : mname,
			lname : lname,
			position_id : position_id,
			employee_id : employee_id,
			activation_code : activation_code,
			username : username,
			password : password
		},
		dataType : 'JSON'
	})
	.done(function(e){
		$('#modal_activate').modal('hide');
		notify(e.message, e.notify);
	})
})

$('#show_password').on('click', function(){
	$('#administration_password').attr('type', $('#administration_password').attr('type') == 'text' ? 'password' : 'text');
})