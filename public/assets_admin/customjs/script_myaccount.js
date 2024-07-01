function getprofiledata(){
    let type = 'GET';
	let url = '/admin/getprofiledata';
	let message = '';
	let form = '';
	
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, '', '', getprofiledataResponse, '', '');

}

function getprofiledataResponse(response){
    if (response.status == 200 || response.status == '200') {
        var data = response.data;
        var details = data.details;
        if(details.phone_number == '' || details.phone_number == null){
            var phone_number = ''
        }
        else{
            var phone_number = details.phone_number;
        }

        setTimeout(function(){
            $('#useremailformcontainer').text(details.email);
            $('#first_name').val(details.first_name);
            $('#user_name_container').text(details.first_name);
            $('#phone_number').val(details.phone_number);
        },500);

        var html = ` ${details.email}
        <br> ${phone_number}`;
        $('#userdetailscontainer').html(html);
        
    }
    else{

    }
}

$('#update_btn').click(function(e){
    e.preventDefault();
	let type = 'POST';
	let url = '/admin/updateprofile';
	let message = '';
	let form = $("#profileform");
	let data = new FormData(form[0]);
	
	// PASSING DATA TO FUNCTION
	$('[name]').removeClass('is-invalid');
	SendAjaxRequestToServer(type, url, data, '', updateprofileResponse, '', ''); 
});

function updateprofileResponse(response){
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        getprofiledata();
    }
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


// $('#personaldataform').submit(function(e){
//     e.preventDefault();
// 	let type = 'POST';
// 	let url = '/customer/updatepersonaldata';
// 	let message = '';
// 	let form = $("#personaldataform");
// 	let data = new FormData(form[0]);
	
// 	// PASSING DATA TO FUNCTION
// 	$('[name]').removeClass('is-invalid');
// 	SendAjaxRequestToServer(type, url, data, '', updatepersonaldataResponse, '', ''); 
// });

// function updatepersonaldataResponse(response){
//     if (response.status == 200 || response.status == '200') {
//         toastr.success(response.message, '', {
//             timeOut: 3000
//         });
//         getprofiledata();
//     }
//     if (response.status == 402) {

//         error = response.message;

//     } else {

//         error = response.responseJSON.message;
//         var is_invalid = response.responseJSON.errors;

//         $.each(is_invalid, function (key) {
//             // Assuming 'key' corresponds to the form field name
//             var inputField = $('[name="' + key + '"]');
//             // Add the 'is-invalid' class to the input field's parent or any desired container
//             inputField.addClass('is-invalid');

//         });
//     }
//     toastr.error(error, '', {
//         timeOut: 3000
//     });
// }

$('[name="name"], [name="first_name"]').on('keydown', function(e) {
    var key = e.keyCode || e.which;
    var char = String.fromCharCode(key);
    var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];

    // Allow control keys and non-numeric characters
    if (controlKeys.includes(e.key) || !char.match(/[0-9]/)) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
});

$(document).ready(function(){
    getprofiledata();
   

    // $('#date_of_birth').datepicker({ dateFormat: 'yyyy/mm/dd' })
    
})