$('#event_title').on('dblclick', function(){
	$('#modal_select_event').modal('show');
})

$('#modal_select_event').on('hidden.bs.modal', function(){
	// $('#attendance_login_container').load('/Framework/views/login/attendance_officer_login.php');
	$('#attendance_login_container').load('/views/login/attendance_officer_login.php');
})

$('#attendance_username, #attendance_password').on('input', function(){
	var username = $('#attendance_username').val();
	var password = $('#attendance_password').val();
	var container = $('#attendance_login_container');

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {
			attendance_login : 1,
			username : username,
			password : password
		},
		dataType : 'JSON',
		success : function(e){
			if(e.bool){
				container.html('<select name="" class="form-control" id="attendance_event_select"><option value="">Choose event</option></select>')
				load_available_events();
			}
		}
	})
})

function load_available_events(){
	var select = $('#attendance_event_select');
	select.find('option').not(':first').remove();

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_available_events : 1},
		dataType : 'JSON',
		success : function(e){
			for(i in e){
				var event_id = e[i].event_id,
					event = e[i].event;

				select.append($('<option>', {
					value : event_id,
					text : event
				}))
			}
		},
		error : function(e){console.log(e)}
	})
}

$('#attendance_event_select').on('change', function(){
	// $('#modal_select_event').modal('hide');

	// var event = $(this).text();
	// $('#event_title').text(event);
	// console.log('asdf')
})

$('#back_to_login').on('dblclick', function(){
	// window.location.replace('/Framework/views/');
	window.location.replace('/views/');
})