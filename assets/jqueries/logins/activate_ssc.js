$(document).ready(function(){
	load_ssc_position();
	load_ssc_department();
});

function load_ssc_position(){
	var select = $('#ssc_position');

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_ssc_position : 1},
		dataType : 'JSON',
		success : function(e){
			for(i in e){
				var position_id = e[i].position_id,
					position = e[i].position;

				select.append($('<option>', {
					value : position_id,
					text : position
				}))
			}
		}
	})
}

function load_ssc_department(){
	var select = $('#ssc_department');

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_ssc_department : 1},
		dataType : 'JSON',
		success : function(e){
			for(i in e){
				var department_id = e[i].department_id,
					department = e[i].department;

				select.append($('<option>', {
					value : department_id,
					text : department
				}))
			}
		}
	})
}

// load_ssc_courses
$('#ssc_department').on('change', function(){
	var department_id = $(this).val(),
		select = $('#ssc_course');

	select.find('option').not(':first').remove();

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {load_ssc_courses : 1, department_id : department_id},
		dataType : 'JSON',
		success : function(e){
			for(i in e){
				var course_id = e[i].course_id,
					course = e[i].course;

				select.append($('<option>', {
					value : course_id,
					text : course
				}))
			}
		}
	})
})

// load_ssc_section
$('#ssc_course, #ssc_year_level').on('change', function(){
	var course_id = $('#ssc_course').val(),
		year_level_id = $('#ssc_year_level').val(),
		select = $('#ssc_section');

	select.find('option').not(':first').remove();

	if(course_id !== '' && year_level_id !== ''){
		$.ajax({
			url : controllers('ActivatesController'),
			method : 'POST',
			data : {
				course_id : course_id,
				year_level_id : year_level_id,
				load_ssc_section : 1
			},
			dataType : 'JSON',
			success : function(e){
				for(i in e){
					var section_id = e[i].section_id,
						section = e[i].section;

					select.append($('<option>', {
						value : section_id,
						text : section
					}))
				}
			}
		})
	}
});

// valdate_ssc
$('#activate_ssc').on('input', function(){
	var position = $('#ssc_position').val(),
		fname = $('#ssc_fname').val(),
		mname = $('#ssc_mname').val(),
		lname = $('#ssc_lname').val(),
		department = $('#ssc_department').val(),
		course = $('#ssc_course').val(),
		year_level = $('#ssc_year_level').val(),
		section = $('#ssc_section').val(),
		student_id = $('#ssc_student_id').val(),
		activation_code = $('#ssc_activation_code').val(),
		username = $('#ssc_username').val(),
		password = $('#ssc_password').val();

	if(validate([position, fname, mname, lname, department, course, year_level, section, student_id, activation_code, username, password])){
		$.ajax({
			url : controllers('ActivatesController'),
			method : 'POST',
			data : {
				validate_ssc : 1,
				position : position,
				fname : fname,
				mname : mname,
				lname : lname,
				department : department,
				course : course,
				year_level : year_level,
				section : section,
				student_id : student_id,
				activation_code : activation_code,
				username : username,
				password : password
			},
			dataType : 'JSON',
			success : function(e){
				if(e.bool == true){
					$('#alert_container').addClass(e.alert).removeClass('hidden alert-danger');
					$('#alert_message').html(e.message);
					$('#ssc_btn_activate').prop('disabled', false).removeClass('btn-muted').addClass('btn-success');
				} else{
					$('#alert_container').addClass(e.alert).removeClass('hidden alert-success');
					$('#alert_message').html(e.message);
					$('#ssc_btn_activate').prop('disabled', true).addClass('btn-muted').removeClass('btn-success');
				}
			}
		})
	} else{
		$('#alert_container').removeClass('alert-success alert-danger').addClass('hidden');
		$('#alert_message').html('');
		$('#ssc_btn_activate').prop('disabled', true).addClass('btn-muted').removeClass('btn-success');
	}
})

// activate ssc
$('#ssc_btn_activate').on('click', function(e){
	e.preventDefault();
	var position = $('#ssc_position').val(),
		fname = $('#ssc_fname').val(),
		mname = $('#ssc_mname').val(),
		lname = $('#ssc_lname').val(),
		department = $('#ssc_department').val(),
		course = $('#ssc_course').val(),
		year_level = $('#ssc_year_level').val(),
		section = $('#ssc_section').val(),
		student_id = $('#ssc_student_id').val(),
		activation_code = $('#ssc_activation_code').val(),
		username = $('#ssc_username').val(),
		password = $('#ssc_password').val();

	$.ajax({
		url : controllers('ActivatesController'),
		method : 'POST',
		data : {
			activate_ssc : 1,
			position : position,
			fname : fname,
			mname : mname,
			lname : lname,
			department : department,
			course : course,
			year_level : year_level,
			section : section,
			student_id : student_id,
			activation_code : activation_code,
			username : username,
			password : password
		},
		dataType : 'JSON',
		success : function(e){
			$('#modal_activate').modal('hide');
			notify(e.message, e.notify);
			
			if(e.bool === false){
				console.log(e.error)
			}
		}
	})
})