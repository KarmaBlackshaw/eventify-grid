var root = 'Framework';

var progress_options = {
 id: 'top-progress-bar',
 color: '#00bfff', 
 height: '2px', 
 duration: 0.2
}

var progressBar = new ToProgress(progress_options);

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$.notifyDefaults({
	allow_dismiss: true,
	animate: {
		enter: 'animated fadeIn',
		exit: 'animated rollOut',
		showProgressbar: true
	},
	mouse_over : 'pause'
});

function notify(message, type, delay = 1){
	// primary, success, danger, warning, info dark, light
	$.notify({
		message : message
	},{
		type : type,
		delay: delay
	});
}

function controllers($file, $var = ''){
	if($var === ''){
		// return '/'+ root +'/controllers/' + $file + '.php';
		return '/controllers/' + $file + '.php';
	} else{
		// return '/'+ root +'/controllers/' + $file + '.php?' + $var;
		return '/controllers/' + $file + '.php?' + $var;
	}
}

function assets($file){
	return '/'+ root +'/assets/' + $file;
}

function views($file, $var = ''){
	if($var === ''){
		return '/'+ root +'/views/' + $file + '.php';
	} else{
		return '/'+ root +'/views/' + $file + '.php?' + $var;
	}
}

function validate(values){
	bool = true
	
	$.each(values, function(index, value){
		if(value !== ''){
			bool = bool && true;
		} else{
			bool = bool && false;
		}
	})
	return bool;
}

function init(){
	return '/'+ root +'/lib/init.php';
}

function logout(){
	$.ajax({
		url : controllers('LoginsController'),
		method : 'POST',
		data : {
			logout : 1
		},
		success : function(e){
			notify('<b>Thank you</b> for using our website!', 'primary');
          window.setTimeout(function(){
            window.location.replace('/'+ root +'/views/')
          }, 2500);
		}
	})
}

function loading(){
	var message = '<div class="d-flex align-items-center"><div class="spinner-border spinner-border-sm mr-3 float-left" role="status" aria-hidden="true"></div><strong>Loading...</strong></div>'
	notify(message, 'success');
}

// function search(input, body){
// 	$(input).on("input", function() {
// 	  var value = $(this).val().toLowerCase();
// 	  $(body + " tr").filter(function() {
// 	    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
// 	  });
// 	});
// }


// $('th').click(function(){
//     var table = $(this).parents('table').eq(0)
//     var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
//     this.asc = !this.asc
//     if (!this.asc){
//       rows = rows.reverse()
//     }
//     for (var i = 0; i < rows.length; i++){
//       table.append(rows[i])
//     }
// })

// function comparer(index){
//     return function(a, b){
//         var valA = getCellValue(a, index), valB = getCellValue(b, index)
//         return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
//     }
// }

// function getCellValue(row, index){ 
//   return $(row).children('td').eq(index).text() 
// }

$.fn.dataTable.ext.classes.sPageButton = 'button primary_button btn-sm p-0';