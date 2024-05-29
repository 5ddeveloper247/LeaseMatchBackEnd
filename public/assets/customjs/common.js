$(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
});

$(document).on('keyup', "[type=number], [type=email]", function (e) {
    if ($(this).attr('maxlength')) {
        if (this.value.length > this.maxLength) {
            this.value = this.value.slice(0, this.maxLength);
        }
    }
});

$(document).ready(function(){
    toastr.options = {
        timeOut : 0,
        extendedTimeOut : 100,
        tapToDismiss : true,
        debug : false,
        fadeOut: 10,
        positionClass : "toast-top-center"
    };

    // Show the UI blocker when an AJAX request starts
    $(document).ajaxStart(function() {
        $('#uiBlocker').show();
    });

    // Hide the UI blocker when an AJAX request completes (whether it succeeds or fails)
    $(document).ajaxStop(function() {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
    });

    // Alternatively, you can use ajaxComplete for specific handling
    $(document).ajaxComplete(function(event, xhr, settings) {
        setTimeout(function(){
            $('#uiBlocker').hide();
        },500);
        
    });
});

function SendAjaxRequestToServer(
    requestType = "GET",
    url,
    data,
    dataType = "json",
    callBack = "",
    spinner_button,
    submit_button
) {
    // console.log(data, url, dataType);
    $.ajax({
        type: requestType,
        url: base_url+url,
        data: data,
        dataType: dataType,
        processData: false,
        contentType: false,
        beforeSend: function (response) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', true);
            // $(submit_button).toggle();
        },
        success: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
        complete: function (data) {
            $(spinner_button).toggle();
            $(submit_button).attr('disabled', false);
            // $(submit_button).toggle();
        },
        error: function (response) {
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
    });
}


// $(document).on('click', '#guest_form_submit', function (e) {
//     console.log('hamza');
// 	e.preventDefault();
// 	let type = 'POST';
// 	let url = '/saveGuestUserDetails';
// 	let message = '';
// 	let form = $('#guest_form');
// 	let data = new FormData(form[0]);
// 	// if ($(this).text() == 'Submit') {
// 	//     url = url;
// 	// }
	    
// 	// PASSING DATA TO FUNCTION
// 	$('[name]').removeClass('is-invalid');
// 	SendAjaxRequestToServer(type, url, data, '', addGuestUserResponse, '', 'submit_button');
	
// });

// function addGuestUserResponse(response) {

//     // SHOWING MESSAGE ACCORDING TO RESPONSE
//     if (response.status == 200 || response.status == '200') {
      
//         toastr.success(response.message, '', {
//             timeOut: 3000
//         });
//         var data = response.data;
        
//         // success response action 

//     } else {
        
//     	error = response.responseJSON.message;
//         var is_invalid = response.responseJSON.errors;
        
//         $.each(is_invalid, function(key) {
//             // Assuming 'key' corresponds to the form field name
//             var inputField = $('[name="' + key + '"]');
//             // Add the 'is-invalid' class to the input field's parent or any desired container
//             inputField.closest('.form-control').addClass('is-invalid');
//         });
//         toastr.error(error, '', {
//             timeOut: 3000
//         });
//     }
// }