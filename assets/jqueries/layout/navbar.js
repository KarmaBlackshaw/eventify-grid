$(document).ready(function(){
	navbar_name();
})

function navbar_name(){
	$.ajax({
		url : controllers('LoginsController'),
		method : 'POST',
		data : {navbar_name : 1},
		success : function(e){
			
		}
	})
}

$('#btn_logout').on('click', function(e){
	e.preventDefault();
	$('#modal_logout').modal('hide');

	$.ajax({
		url : controllers('LoginsController'),
		method : 'POST',
		data : {logout : 1},
		success : function(e){
			// location.reload();
			// window.location.replace('/Framework/views/');
			window.location.replace('/views/');
			// window.history.pushState(null, null, '/Framework/views/');
		}
	})
})

$('#logout').on('click', function(e){
	e.preventDefault();
	$('#modal_logout').modal('show');
});

$('.nav-item > a.nav-link').on('click', function(e){
	// e.preventDefault();
	// var link = $(this).attr('href');
	// $('.nav-item > a.nav-link').removeClass('active font-weight-bold');
	// $(this).addClass('active font-weight-bold');
	// window.location.href = link;
})

$('#change_profile_picture').on('click', function(){
	$("#input_change_profile").trigger('click')
})

$('#change_cover_photo').on('click', function(){
	$("#input_change_cover").trigger('click')
})

$('#input_change_profile, #input_change_cover').on('change', function(){
	$('#form_change_profile').submit();
})