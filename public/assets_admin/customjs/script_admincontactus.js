function getContactUsPageData(){
    let type = 'POST';
	let url = '/admin/getContactUsPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getContactUsPageDataResponse, '', 'submit_button');
}

function getContactUsPageDataResponse(response){

	var data = response.data;
	var contactus_list = data['contactus_list'];
	
	makeContactUsListing(contactus_list);
}

function makeContactUsListing(contactus_list){

	var html = '';

	if(contactus_list.length > 0){
		$.each(contactus_list, function (index, value) {
			
			if(value.reply == null || value.reply == ''){
				var status = `<span class="badge rounded-pill bg-danger">New</span>`;
				var reply_btn = `<button class="inquiry-btn btn-sm editButton text-center replybtn" data-id="${value.id}">Reply</button>`;
			}else{
				var status = `<span class="badge rounded-pill bg-success">Replied</span>`;
				var reply_btn = `<button class="inquiry-btn btn-sm editButton text-center replybtn" data-id="${value.id}">View</button>`;
			}
			html += `<tr class="col-12">
						<td class="col-1">${index + 1}</td>
						<td class="col-4">${ value.email }</td>
						<td>${ trimText(value.message, 50) }</td>
						<td class="text-center">
							${status}
						</td>
						<td class="text-center">
							<span>${value.replied_by!=null ? value.replied_by.first_name : '---'}</span>
						</td>
						<td class="text-center">
							${reply_btn}
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="6"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#listing_html").html(html);
}


$(document).on('click', '.replybtn', function (e) {
    var contact_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getSpecificContactUsDetail';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', contact_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getSpecificContactUsResponse, '', '.replybtn');
	
});

function getSpecificContactUsResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        var data = response.data;
        var detail = data.detail;

		$(".listing_section").hide();
		$(".detail_section").show();

		if(detail != null){
			$("#contact_id").val(detail.id);
			$("#contact_email").text(detail.email);
			$("#contact_phone").text(detail.phone);
			$("#contact_message").text(detail.message);
		
			if(detail.reply ==  null  || detail.reply == ''){
				$("#reply_message").val('').prop('disabled', false);
				$("#contactReply_submit").show();
			}else{
				$("#reply_message").val(detail.reply).prop('disabled', true);
				$("#contactReply_submit").hide();
			}
		}
    }
}

$(document).on('click', '#contactReply_submit', function (e) {
    
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/saveContactReply';
	let message = '';
	let form = $('#addreply_form');
	let data = new FormData(form[0]);
	data.append('id', contact_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', saveContactReplyResponse, '', '#contactReply_submit');
	
});

function saveContactReplyResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      	
		$(".listing_section").show();
		$(".detail_section").hide();

		getContactUsPageData();

    }else{

		if (response.status == 402) {

            error = response.message;

        } else {
			error = response.responseJSON.message;
			var is_invalid = response.responseJSON.errors;
			
			$.each(is_invalid, function(key) {
				// Assuming 'key' corresponds to the form field name
				var inputField = $('[name="' + key + '"]');
				// Add the 'is-invalid' class to the input field's parent or any desired container
				inputField.closest('.form-control').addClass('is-invalid');
			});
		}
        toastr.error(error, '', {
            timeOut: 3000
        });
	}
}


function backToList(){
    $(".detail_section").hide();
    $(".listing_section").show(1000);
}



$(document).ready(function () {

    getContactUsPageData();
});