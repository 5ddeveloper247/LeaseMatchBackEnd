function addNewReceord(){
    $(".pricingList_section").hide();
    $(".addPricing_section").show(1000);
}
function backToList(){
    $(".addPricing_section").hide();
    $(".pricingList_section").show(1000);
}

// function editPricingPlan(plan_id){
//     let type = 'POST';
// 	let url = '/admin/editSpecificPlan';
// 	let message = '';
// 	let form = $('#guest_form');
// 	let data = new FormData();
//     data.append('plan_id', plan_id);
// 	// PASSING DATA TO FUNCTION
// 	SendAjaxRequestToServer(type, url, data, '', addGuestUserResponse, '', 'submit_button');
// }
// $(document).on('click', '#guest_form_submit', function (e) {
//     console.log('hamza');
// 	e.preventDefault();
	// let type = 'POST';
	// let url = '/saveGuestUserDetails';
	// let message = '';
	// let form = $('#guest_form');
	// let data = new FormData(form[0]);
	// // if ($(this).text() == 'Submit') {
	// //     url = url;
	// // }
	    
	// // PASSING DATA TO FUNCTION
	// $('[name]').removeClass('is-invalid');
	// SendAjaxRequestToServer(type, url, data, '', addGuestUserResponse, '', 'submit_button');
	
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




$(document).ready(function () {
    
    //console.log('success');
  
});