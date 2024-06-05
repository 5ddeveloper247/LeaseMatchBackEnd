function addNewReceord(){
	let form = $('#addPlan_form');
	form.trigger("reset");
    $(".pricingList_section").hide();
    $(".addPricing_section").show(1000);
}
function backToList(){
    $(".addPricing_section").hide();
    $(".pricingList_section").show(1000);
}

function editPricingPlan(plan_id){
    let type = 'POST';
	let url = '/admin/editSpecificPlan';
	let message = '';
	let form = '';
	let data = new FormData();
    data.append('plan_id', plan_id);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', editPricingPlanResponse, '', 'submit_button');
}

function editPricingPlanResponse(response){

	var data = response.data;
	var plan_detail = data['plan_detail'];
	
	console.log(plan_detail);
	
	let form = $('#addPlan_form');
	form.trigger("reset");

	$("#plan_id").val(plan_detail.id);
	$("#package_title").val(plan_detail.title != null ? plan_detail.title : '');
	$("#initial_price").val(plan_detail.initial_price != null ? plan_detail.initial_price : '');
	$("#monthly_price").val(plan_detail.monthly_price != null ? plan_detail.monthly_price : '');
	$("#number_matches").val(plan_detail.number_of_matches != null ? plan_detail.number_of_matches : '');

	if(plan_detail.directly_contact_flag != null && plan_detail.directly_contact_flag == '1'){
		$("#tenant_directly_contact").prop('checked', true);
	}else{
		$("#tenant_directly_contact").prop('checked', false);
	}
	
	if(plan_detail.process_application_flag != null && plan_detail.process_application_flag == '1'){
		$("#process_application").prop('checked', true);
	}else{
		$("#process_application").prop('checked', false);
	}

	if(plan_detail.necessary_doc_flag != null && plan_detail.necessary_doc_flag == '1'){
		$("#necessary_document").prop('checked', true);
	}else{
		$("#necessary_document").prop('checked', false);
	}

	$(".pricingList_section").hide();
    $(".addPricing_section").show(1000);
}
$(document).on('click', '#save_plan_submit', function (e) {
    console.log('hamza');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/savePlanDetail';
	let message = '';
	let form = $('#addPlan_form');
	let data = new FormData(form[0]);
	// if ($(this).text() == 'Submit') {
	//     url = url;
	// }
	    
	// PASSING DATA TO FUNCTION
	$('[name]').removeClass('is-invalid');
	SendAjaxRequestToServer(type, url, data, '', addplanDetailResponse, '', '#save_plan_submit');
	
});

function addplanDetailResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        var data = response.data;
        location.reload();
        // success response action 

    } else {
        
    	error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;
        
        $.each(is_invalid, function(key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.closest('.form-control').addClass('is-invalid');
        });
        toastr.error(error, '', {
            timeOut: 3000
        });
    }
}




$(document).ready(function () {
    
    //console.log('success');
  
});