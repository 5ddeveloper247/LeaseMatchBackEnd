$(document).on('click', '.view_property_detail', function (e) {

    var prop_id = $(this).attr('data-id');
    console.log(prop_id);
    $("#landlord_id").val(prop_id);

    setTimeout(function () {
        $("#detail_form").submit();
    }, 500);

});

$(document).on('click', '#contact_lanlord_btn', function (e) {

    var landlord_id = $(this).attr('data-id');
    e.preventDefault();
    let type = 'POST';
    let url = '/customer/viewContactInfo';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', landlord_id);

    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', viewContactResponse, '', '#contact_lanlord_btn');
});

function viewContactResponse(response) {

    if (response.status == 200) {
        var data = response.data;
        var detail = data.landlord_detail;
        if (detail != null) {
            $("#company_name").text(detail.company_name);
            $("#landlord_name").text(detail.full_name);
            $("#landlord_company").text(detail.company_name);
            $("#landlord_email").text(detail.email);
            $("#landlord_phone").text(detail.phone_number);

            $(".contact_landlord_section").css({
                "filter": "unset"
            });
        }
    }
    else {
        $("#company_name").text('N/A');
        $("#landlord_name").text('N/A');
        $("#landlord_company").text('N/A');
        $("#landlord_email").text('N/A');
        $("#landlord_phone").text('N/A');

        $(".contact_landlord_section").css({
            "filter": "blur(5px)"
        });
        toastr.error(response.message, '', {
            timeOut: 3000
        });
    }
}


$('#processApp_btn').click(function (e) {
    e.preventDefault();
    let type = 'POST';
    let url = '/customer/processAppRequest';
    let message = '';
    let form = $("#processApp_form");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('[name]').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', processAppRequestResponse, '', '');
});

function processAppRequestResponse(response) {
    try {
        if (response && (response.status == 200 || response.status == '200')) {
            // Handle success response
            toastr.success(response.message || 'Request processed successfully', '', {
                timeOut: 3000
            });

            $("#process_message").val('');
            $("#processApp_btn").prop('disabled', true);
        } else {
          
            let errorMessage = 'An error occurred'; // Default error message
            if (response && response.status == 402) {
                // Payment required or specific error handling
                errorMessage = response.message || 'An error occured';
            } else if (response && response.responseJSON) {
                // General error handling for other status codes
                errorMessage = response.responseJSON.message || errorMessage;
                let validationErrors = response.responseJSON.errors;

                if (validationErrors) {
                    $.each(validationErrors, function (key) {
                        // Adding 'is-invalid' class to input fields based on validation errors
                        var inputField = $('[name="' + key + '"]');
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                        }
                    });
                }
            }

            // Show the error message using toastr
            toastr.error(errorMessage, '', {
                timeOut: 3000
            });
        }
    } catch (error) {
        // Catch any unexpected errors
        console.error('Error processing request:', error);
        toastr.error('An unexpected error occurred. Please try again.', '', {
            timeOut: 3000
        });
    }
}



$(document).ready(function () {

    //console.log('success');

});


$('#tenant_enquiry_document_form').submit(function (e) {
    var isValid = true;
    $('input[type="file"]').each(function () {
        if ($(this).val() === '') {
            isValid = false;
            toastr.error($(this).attr('data-name') + ' is required', '', {
                timeOut: 3000
            });

            return false; // Break the loop
        }
    });
    if (!isValid) {
        e.preventDefault();
        return;
    }
    let type = 'POST';
    let url = '/customer/uploadTenantEnquiryDocuments';
    let message = '';
    let form = $("#tenant_enquiry_document_form");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    $('[name]').removeClass('is-invalid');
    SendAjaxRequestToServer(type, url, data, '', uploadTenantEnquiryDocumentsResponse, '', '#tenant_enquiry_document_form_submit_btn');
});


function uploadTenantEnquiryDocumentsResponse(response) {
    try {
        if (response && (response.status == 200 || response.status == '200')) {
            // Handle success response
            toastr.success(response.message || 'Documents uploaded successfully', '', {
                timeOut: 3000
            });

            location.reload();

            // Reset the form after successful upload
            if ($("#tenant_enquiry_document_form").length) {
                $("#tenant_enquiry_document_form")[0].reset();
            }
        } else {
            let errorMessage = 'An error occurred'; // Default error message

            if (response && response.status == 402) {
                // Handle specific status code 402
                errorMessage = response.message || 'Payment required';
            } else if (response && response.responseJSON) {
                // Handle general errors with responseJSON
                errorMessage = response.responseJSON.message || errorMessage;

                let validationErrors = response.responseJSON.errors;

                if (validationErrors) {
                    $.each(validationErrors, function (key) {
                        // Add 'is-invalid' class to the fields with errors
                        var inputField = $('[name="' + key + '"]');
                        if (inputField.length) {
                            inputField.addClass('is-invalid');
                        }
                    });
                }
            }

            // Show error message using toastr
            toastr.error(errorMessage, '', {
                timeOut: 3000
            });
        }
    } catch (error) {
        // Handle unexpected errors
        console.error('Error uploading documents:', error);
        toastr.error('An unexpected error occurred. Please try again.', '', {
            timeOut: 3000
        });
    }
}
