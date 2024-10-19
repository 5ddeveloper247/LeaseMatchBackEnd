function getprofiledata() {
    let type = 'GET';
    let url = '/customer/getprofiledata';
    let message = '';
    let form = '';


    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, '', '', getprofiledataResponse, '', '');

}

function getprofiledataResponse(response) {
    // Check if the response has a status property
    if (response && (response.status === 200 || response.status === '200')) {
        var data = response.data || {}; // Fallback to an empty object if data is undefined
        var details = data.details || {}; // Fallback to an empty object if details is undefined

        // Handle phone number safely
        var phone_number = details.phone_number || ''; // Fallback to empty string

        console.log(details);
        console.log("Debug: User details retrieved.");

        // Safely set user email and name
        $('#useremailformcontainer').text(details.email || '');
        $('#first_name').val(details.first_name || '');
        $('#user_name_container').text(details.first_name || '');

        // Create user details HTML safely
        var html = `
            ${details.email || ''}
            <br> ${phone_number}
        `;
        $('#userdetailscontainer').html(html);

        // Safely access personal info
        var personal_info = details.personal_info || {}; // Fallback to empty object
        $('#email').val(personal_info.email || '');
        $('#name').val(personal_info.name || '');
        $('#user_name_container_personal').text(personal_info.name || '');
        $('#phone_number_personal').val(personal_info.phone_number || '');
        $('#date_of_birth').val(personal_info.date_of_birth || '');

        // Create personal user details HTML safely
        var personalHtml = `
            ${personal_info.email || ''}
            <br> ${phone_number}
        `;
        $('#userdetailscontainer_personal').html(personalHtml);
    } else {
        // Handle errors or unexpected status codes
        var errorMessage = response && response.message ? response.message : 'An unexpected error occurred.';
        console.error(errorMessage); // Log the error
        toastr.error(errorMessage, '', { timeOut: 3000 }); // Display error message
    }
}


$('#update_btn').click(function (e) {
    e.preventDefault();
    let type = 'POST';
    let url = '/customer/updateprofile';
    let message = '';
    let form = $("#profileform");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('[name]').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', updateprofileResponse, '', '');
});

function updateprofileResponse(response) {
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


$('#personaldataform').submit(function (e) {
    e.preventDefault();
    let type = 'POST';
    let url = '/customer/updatepersonaldata';
    let message = '';
    let form = $("#personaldataform");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('[name]').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', updatepersonaldataResponse, '', '');
});

function updatepersonaldataResponse(response) {
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
// number not allowed
$('[name="name"], [name="first_name"]').on('keydown', function (e) {
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


$(document).ready(function () {
    getprofiledata();


    // $('#date_of_birth').datepicker({ dateFormat: 'yyyy/mm/dd' })

})
