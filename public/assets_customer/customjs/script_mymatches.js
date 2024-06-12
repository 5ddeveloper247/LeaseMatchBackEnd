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

$(document).ready(function () {
    
    //console.log('success');
  
});