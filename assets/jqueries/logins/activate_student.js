// validate_student
$('#activate_student').on('input', function(){
	var data = $(this).serializeArray();
	data[data.length] = {name : 'validate_student', value : 1};

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : data,
		dataType : 'JSON'
	})
	.done(function(e){
		$('#alert_container').removeClass('hidden ' + e.remove_alert).addClass(e.alert);
		$('#alert_message').html(e.message);
		$('#student_btn_activate').prop('disabled', e.disabled).removeClass(e.btn_remove_class).addClass(e.btn_class);
	})
})

// activate_student
$('#activate_student').on('submit', function(e){
	e.preventDefault();
	var data = $(this).serializeArray();
	data[data.length] = {name : 'activate_student', value : 1};

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : data,
		dataType : 'JSON'
	})
	.done(function(e){
		$('#modal_activate').modal('hide');
		notify(e.message, e.notify);
	})
	.fail(function(e){
		console.log(e)
	})
})

$('#show_password').on('click', function(){
	$('#student_password').attr('type', $('#student_password').attr('type') == 'text' ? 'password' : 'text');
})