$(document).ready(function(){
	
	$('#spinner').fadeOut("slow");
	$('#btn_login').text("Login");
})

// change_modal_content_activate
$('#activate_user_level').on('change', function(){
	var user_level = $(this).val(),
		content = $('#content');

	if(user_level === ""){
		content.html("");
	} else{
		if(user_level == 'student'){
			content.load('/views/login/activate_student.php')
		} else if(user_level == 'administration'){
			content.load('/views/login/activate_administration.php')
		}
	}
})

// validate_login
$('#login_username, #login_password').on('input', function(){
	var username = $('#login_username').val(),
		password = $('#login_password').val(),
		button = $('#btn_login');

	if(validate([username, password])){
		button.prop('disabled', false);
	} else{
		button.prop('disabled', true);
	}
})

$('#index_system_title').on('dblclick', function(){
	// window.location.replace("/Framework/views/student/attendance.php");
	window.location.replace("/views/student/attendance.php");
})