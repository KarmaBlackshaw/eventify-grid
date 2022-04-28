var signaturePad = new SignaturePad($('#signature-pad')[0], {
  backgroundColor: 'rgba(255, 255, 255, 0)',
  penColor: 'rgb(0, 0, 0)'
});

var saveButton = $('#save');
var cancelButton = $('#clear');
var name = $('#sign_name').val();
var alert = $('#signature_alert');

saveButton.on('click', function (event) {
	if(signaturePad.isEmpty()){
		alert.removeClass('hidden').addClass('alert-danger').html('<b>Error!</b> Please enter your signature!')
	} else{
		var data = signaturePad.toDataURL('image/png');

		$.ajax({
			url : controllers('MISController'),
			method : 'POST',
			data : {
				save_signature : data
			},
			dataType : 'JSON',
			success : function(e){
				alert.removeClass('alert-danger alert-success hidden').addClass(e.alert).html(e.message)
			},
			error : function(e){
				console.log(e)
			}
		})
	}
	
	signaturePad.clear();
});

cancelButton.on('click', function (event) {
  signaturePad.clear();
  alert.addClass('hidden').removeClass('alert-danger alert-success');
});