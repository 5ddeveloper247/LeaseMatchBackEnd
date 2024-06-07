

$(document).on('click', '#saveSettings_btn', function (e) {
    
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/saveApiSettings';
	let message = '';
	let form = $("#apiSettings_form");
	let data = new FormData(form[0]);
	
	// PASSING DATA TO FUNCTION
	$('[name]').removeClass('is-invalid');
	SendAjaxRequestToServer(type, url, data, '', saveApiSettingsResponse, '', '#saveSettings_btn');
});
function saveApiSettingsResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        toastr.success(response.message, '', {
            timeOut: 3000
        });
    } else {
        
    	error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;
        
        $.each(is_invalid, function(key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');
        });
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}



$(document).ready(function () {

    
});

