$(document).on('click', '.view_property_detail', function (e) {
    
	var prop_id = $(this).attr('data-id');
    console.log(prop_id);
    $("#landlord_id").val(prop_id);

    setTimeout(function(){
        $("#detail_form").submit();
    },1000);

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
    
        if(detail != null){
            $("#company_name").text(detail.company_name);
            $("#landlord_name").text(detail.full_name);
            $("#landlord_company").text(detail.company_name);
            $("#landlord_email").text(detail.email);
            $("#landlord_phone").text(detail.phone_number);
             
            $(".contact_landlord_section").css({
                "filter": "unset"
            });
        }
    }else{
        
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

$('#processApp_btn').click(function(e){
    e.preventDefault();
	let type = 'POST';
	let url = '/customer/processAppRequest';
	let message = '';
	let form = $("#processApp_form");
	let data = new FormData(form[0]);
	
	// PASSING DATA TO FUNCTION
	$('[name]').removeClass('is-invalid');
	SendAjaxRequestToServer(type, url, data, '', processAppRequestResponse, '', '#processApp_btn'); 
});

function processAppRequestResponse(response){
    if (response.status == 200 || response.status == '200') {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        $("#process_message").val('');
        $("#processApp_btn").prop('disabled', true);
    }else{
        if (response.status == 402) {
            error = response.message;
        } else {
            error = response.responseJSON.message;
            var is_invalid = response.responseJSON.errors;

            $.each(is_invalid, function (key) {
                // Assuming 'key' corresponds to the form field name
                var inputField = $('[name="' + key + '"]');
                inputField.addClass('is-invalid');
            });
        }
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}

$(document).ready(function () {
    
    //console.log('success');
  
});