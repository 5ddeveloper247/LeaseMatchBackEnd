$('#get_otp_btn').click(function(){
    let type = 'POST';
	let url = '/customer/forgetpasswordemailvalidate';
	let email = $('#email').val();
	let data = new FormData();
    data.append('email', email);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', forgetpasswordemailvalidateResponse, '', 'get_otp_btn');
});


function forgetpasswordemailvalidateResponse(response){
    
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $('#email_div').addClass('hidden');
        $('#get_otp_btn').addClass('hidden');
        $('#otp_div').removeClass('hidden');
        $('#verify_otp_btn').removeClass('hidden');


    }
    else{
    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}
    
}


// verify otp 

$('#verify_otp_btn').click(function(){
    let type = 'POST';
	let url = '/customer/verifyotp';
	let email = $('#email').val();
	let otp = $('#otp').val();
	let data = new FormData();
    data.append('email', email);
    data.append('otp', otp);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', verifyotpResponse, '', 'verify_otp_btn');
});


function verifyotpResponse(response){
    
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $('#email_div').addClass('hidden');
        $('#get_otp_btn').addClass('hidden');
        $('#otp_div').addClass('hidden');
        $('#verify_otp_btn').addClass('hidden');
        $('#password_div').removeClass('hidden');
        $('#reset_password_btn').removeClass('hidden');


    }
    else{

    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}
   
}


// change password 

$('#reset_password_btn').click(function(){
    let type = 'POST';
	let url = '/customer/resetpassword';
	let form = document.getElementById('forgotpasswordform');
	let data = new FormData(form);
    $('#reset_password_btn').prop('disabled', true);

	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', resetpasswordResponse, '', 'reset_password_btn');
});


function resetpasswordResponse(response){
    
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        setTimeout(function(){
            window.location = '/customer';
        },1500);
    
       


    }

    else{
    if (response.status == 402) {
       $('#reset_password_btn').prop('disabled', false);

        error = response.message;

    } else {
       $('#reset_password_btn').prop('disabled', false);

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}
   
}