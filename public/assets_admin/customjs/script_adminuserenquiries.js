function getEnquiriesPageData(){
    let type = 'POST';
	let url = '/admin/getEnquiriesPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getEnquiriesPageDataResponse, '', 'submit_button');
}

function getEnquiriesPageDataResponse(response){

	var data = response.data;
	var enquiries = data['enquiries'];
	var waiting_enquiries = data['waiting_enquiries'];
    
	makeInProcessEnquiryListing(enquiries);
	makeWaitingEnquiryListing(waiting_enquiries);
}

function makeInProcessEnquiryListing(enquiries){

	var html = '';

	if(enquiries.length > 0){
		$.each(enquiries, function (index, value) {
			var landlord = value.landlord;
			if(value.enquiry_requests != null && value.enquiry_requests[0].type == '1'){
				var enqType = 'Application Request';
			}else{
				var enqType = 'Document Upload';
			}

			var notif_icon = '';
			if(value.status == '1' || value.status == '2' || value.status == '5'){
				notif_icon = '<span class="notif-icon"></span>';
			}
			
			html += `<tr class="identify">
						<td class="nowrap grid-p-searchby">${index + 1} ${notif_icon}</td>
						<td class="grid-p-searchby">${trimText(landlord.full_name, 20)}</td>
						<td class="grid-p-searchby">${enqType}</td>
						<td class="grid-p-searchby">${value.enquiry_requests != null ? trimText(value.enquiry_requests[0].message, 30) : ''}</td>
						<td class="nowrap grid-p-searchby text-center" >${landlord.property_detail != null ? landlord.property_detail.property_type : ''}</td>
						<td class="nowrap grid-p-searchby text-center" >${landlord.property_detail != null ? landlord.property_detail.appartment_number : ''}</td>
						<td class="nowrap grid-p-searchby text-center" >${value.date != null ? formatDate(value.date) : ''}</td>
						<td class="nowrap grid-p-searchby text-center" >${value.status_text}</td>
						
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye " onclick="viewEnquiryDetail(${value.id})" title="View Enquiry Detail" ></button>
							</div>
						</td>
					</tr>`;
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#processlisting_tbody").html(html);
}

function makeWaitingEnquiryListing(waiting_enquiries){

	var html = '';

	if(waiting_enquiries.length > 0){
		$.each(waiting_enquiries, function (index, value) {
			var landlord = value.landlord;
			if(value.enquiry_requests != null && value.enquiry_requests[0].type == '1'){
				var enqType = 'Application Request';
			}else{
				var enqType = 'Document Upload';
			}
			html += `<tr class="identify1">
						<td class="nowrap grid-p-searchby1">${index + 1}</td>
						<td class="grid-p-searchby1">${trimText(landlord.full_name, 20)}</td>
						<td class="grid-p-searchby1">${enqType}</td>
						<td class="grid-p-searchby1">${value.enquiry_requests != null ? trimText(value.enquiry_requests[0].message, 30) : ''}</td>
						<td class="nowrap grid-p-searchby1 text-center" >${landlord.property_detail != null ? landlord.property_detail.property_type : ''}</td>
						<td class="nowrap grid-p-searchby1 text-center" >${landlord.property_detail != null ? landlord.property_detail.appartment_number : ''}</td>
						<td class="nowrap grid-p-searchby1 text-center" >${value.date != null ? formatDate(value.date) : ''}</td>
						<td class="nowrap grid-p-searchby1 text-center" >${value.status_text}</td>
						
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye" onclick="viewEnquiryDetail(${value.id})" title="View Enquiry Detail"></button>
							</div>
						</td>
					</tr>`;
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#waitinglisting_tbody").html(html);
}

$(document).on('click', '#search_filter_submit', function (e) {
    
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/searchEnquiryListing';
	let message = '';
	let form = $("#filter_form");
	let data = new FormData(form[0]);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', searchEnquiryListingResponse, '', '#search_filter_submit');
});
function searchEnquiryListingResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
	
    if (response.status == 200 || response.status == '200') {
		var data = response.data;
		var enquiries_list = data.enquiries;
		
		makeInProcessEnquiryListing(enquiries_list);
    }else{
		toastr.error(response.message, '', {
            timeOut: 3000
        });
	}
}
$(document).on('click', '#reset_filter_btn', function (e) {

	let form = $('#filter_form');
    form.trigger("reset");
	getEnquiriesPageData();
});

function viewEnquiryDetail(enquiry_id) {
	
	let type = 'POST';
	let url = '/admin/getEnquiryLandlordDetail';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', enquiry_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getSpecificEnquiryResponse, '', '.view_enquiry_detail');
	
}

function getSpecificEnquiryResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        var data = response.data;
        var enquiry_detail = data.enquiry_detail;

		if(enquiry_detail != null){

			var status = enquiry_detail.status;
			if(status == '1' ){		// application requested
				$("#action_button").html(`<button type="button" class="site_btn md simple border changeStatusEnquiry" data-status="8">Cancel</button>
											<button type="button" class="site_btn md long" onclick="confirmEnquiry();">Confirm Request</button>`);
			}else if(status == '2'){	// application confirmed
				$("#action_button").html(`<button type="button" class="site_btn md simple border changeStatusEnquiry" data-status="8">Cancel</button>
											<button type="button" class="site_btn md long" onclick="enquiryRequestForDoc();">Request For Document</button>`);
			}else if(status == '4'){
				$("#action_button").html(`<button type="button" class="site_btn md simple border changeStatusEnquiry" data-status="8">Cancel</button>
											<button type="button" class="site_btn md long" disabled>Waiting for Document Upload</button>`);
			}else if(status == '5'){
				$("#action_button").html(`<button type="button" class="site_btn md simple border changeStatusEnquiry" data-status="8">Cancel</button>
											<button type="button" class="site_btn md long" onclick="viewEnquiryDocs();">View Documents</button>`);
			}else if(status == '6' || status == '8'){
				$("#action_button").html(`<button type="button" class="site_btn md long" disabled>${enquiry_detail.status_text}</button>`);
			}else if(status == '7'){
				$("#action_button").html(`<button type="button" class="site_btn md simple border changeStatusEnquiry" data-status="8">Cancel</button>
											<button type="button" class="site_btn md long" disabled>${enquiry_detail.status_text}</button>`);
			}else if(status == '9'){		// waiting
				$("#action_button").html(`<button type="button" class="site_btn md long" onclick="confirmEnquiry();">Confirm Request</button>`);
			}

			$("#enquiry_id").val(enquiry_detail.id);

			var landlord = enquiry_detail.landlord;

			var propertydetail = landlord.property_detail;
			var rentalInfo = landlord.rental_detail;
			var tenantInfo = landlord.tenant_detail;
			var additionalInfo = landlord.additional_detail;
			
			$("#full_name").val(landlord.full_name);
			$("#email").val(landlord.email);
			$("#phone_number").val(landlord.phone_number);
			$("#company_name").val(landlord.company_name);
			
			if(propertydetail != null){
				$("#street_address").val(propertydetail.street_address);
				$("#appartment_number").val(propertydetail.appartment_number);
				$("#neighbourhood").val(propertydetail.neighbourhood);
				$("#property_type").val(propertydetail.property_type);
				$("#number_of_units").val(propertydetail.number_of_units);
				$("#year_built").val(propertydetail.year_built);
				$("#major_renovation").val(propertydetail.major_renovation);
			}
			
			if(rentalInfo != null){
				$("#size_square_feet").val(rentalInfo.size_square_feet);
				$("#number_of_bedrooms").val(rentalInfo.number_of_bedrooms);
				$("#number_of_bathrooms").val(rentalInfo.number_of_bathrooms);
				$("#rental_type").val(rentalInfo.rental_type);
				$("#monthly_rent").val(rentalInfo.monthly_rent);
				$("#security_deposit").val(rentalInfo.security_deposit);
				$("#renwal_option").val(rentalInfo.renwal_option);
				$("#lease_duration").val(rentalInfo.lease_duration);
				$("#list_of_amenities").val(rentalInfo.list_of_amenities);
				$("#special_feature").val(rentalInfo.special_feature);
			}
			

			if(tenantInfo != null){
				$("#tenant_characteristics").val(tenantInfo.tenant_characteristics);
				$("#credit_score").val(tenantInfo.credit_score);
				$("#income_requirements").val(tenantInfo.income_requirements);
				$("#rental_history").val(tenantInfo.rental_history);
			}
			
			if(additionalInfo != null){
				$("#special_note").val(additionalInfo.special_note);
			}

			var property_images = landlord.property_images;
			var images_html = '';
			if(property_images.length > 0){
				$.each(property_images, function (index, value) {
					images_html += `<li id="">
										<div class="thumb">
											<img src="${value.path}" alt="">
										</div>
									</li>`;
						
				});
			}

			$("#propertyImages_html").html(images_html);
		}

		$(".listing_section").hide();
		$(".detail_section").show();

    }
}

function confirmEnquiry() {
	$("html").addClass("flow");
	$("#confirm_popup").fadeIn();	
}
$(document).on('click', '.close_enquiry_confirm', function (e) {
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();	
});

$(document).on('click', '.enquiry_confirmed', function (e) {
	
    var enquiry_id = $('#enquiry_id').val();

	e.preventDefault();
	let type = 'POST';
	let url = '/admin/changeEnquiryStatusConfirmed';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', enquiry_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeEnquiryStatusConfirmedResponse, '', '.view_enquiry_detail');
});

function changeEnquiryStatusConfirmedResponse(response){
	
	if (response.status == 200 || response.status == '200') {

		viewEnquiryDetail($('#enquiry_id').val());
		
		$("html").removeClass("flow");
		$("#confirm_popup").fadeOut();	

		toastr.success(response.message, '', {
            timeOut: 3000
        });

	}else{

		$("html").removeClass("flow");
		$("#confirm_popup").fadeOut();
		
		toastr.error(response.message, '', {
            timeOut: 3000
        });
	}
}

function enquiryRequestForDoc(){
	$("input[id*=req_docs_chk_]").prop('checked', false).prop('disabled', false);
	$("html").addClass("flow");
	$("#req_doc_popup").fadeIn();	
}

$(document).on('click', '.request_doc_submit', function (e) {
	
    var enquiry_id = $('#enquiry_id').val();

	e.preventDefault();
	let type = 'POST';
	let url = '/admin/changeEnquiryStatusReqDoc';
	let message = '';
	let form = $("#required_doc_form");
	let data = new FormData(form[0]);
	data.append('enquiry_id', enquiry_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeEnquiryStatusReqDocResponse, '', '.view_enquiry_detail');
});

function changeEnquiryStatusReqDocResponse(response){

	if (response.status == 200) {

		viewEnquiryDetail($('#enquiry_id').val());
		
		$("html").removeClass("flow");
		$("#req_doc_popup").fadeOut();	
        
		toastr.success(response.message, '', {
            timeOut: 3000
        });
	}else {
		error = response.responseJSON.message;
		toastr.error(error, '', {
			timeOut: 3000
		});
	}
}

function viewEnquiryDocs(){

	var enquiry_id = $('#enquiry_id').val();

	let type = 'POST';
	let url = '/admin/viewEnquiryDocs';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('enquiry_id', enquiry_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', viewEnquiryDocsResponse, '', '.submit_button');
}

function viewEnquiryDocsResponse(response){

	if (response.status == 200) {

		var data = response.data;
		var enquiry_docs = data.enquiry_docs;
		var html = '';

		if(enquiry_docs.length > 0){
			$.each(enquiry_docs, function (index, value) {
				html += `<div class="col-sm-12">
							<div class="form_blk">
								<div class="lbl_btn">
									<a href="${value.path}" title="Download" download>
										<img src="${base_url}/assets/images/icon-file.svg" style="height: 25px;width: 25px;">
									</a>
									<label for="req_docs_chk_">${value.required_document.name}</label>
								</div>
							</div>
						</div>`;
			});
		}else{
			html += `<div class="col-sm-12">
						<p class="text-center">No record found!</p>
					</div>`;
		}

		$("#uploaded_docs_section").html(html);
		
		$("html").addClass("flow");
		$("#view_docs_popup").fadeIn();	
        
		// toastr.success(response.message, '', {
        //     timeOut: 3000
        // });
	}else {
		error = response.responseJSON.message;
		toastr.error(error, '', {
			timeOut: 3000
		});
	}
}

$(document).on('click', '.changeStatusEnquiry', function (e) {
	var status = $(this).attr('data-status');

	if(status == '6'){		// approve status
		$("#status_confirm_msg").html(`Are you sure you want to approved this application request...!!!`);
	}else if(status == '7'){	// return status
		$("#status_confirm_msg").html(`Are you sure you want to return this application request...!!!`);
	}else if(status == '8'){
		$("#status_confirm_msg").html(`Are you sure you want to cancel this application request...!!!`);
	}
	$("#changeStatusEnquiryConfirm").attr('data-status', status);

	$("#view_docs_popup").fadeOut();
	$("#confirm_popup1").fadeIn();

});
$(document).on('click', '.close_enquiry_confirm1', function (e) {
	$("html").removeClass("flow");
	$("#confirm_popup1").fadeOut();	
});

$(document).on('click', '#changeStatusEnquiryConfirm', function (e) {
	
    var enquiry_id = $('#enquiry_id').val();
	var status = $(this).attr('data-status');

	e.preventDefault();
	let type = 'POST';
	let url = '/admin/changeEnquiryStatus';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('enquiry_id', enquiry_id);
	data.append('status', status);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeEnquiryStatusResponse, '', '.view_enquiry_detail');
});

function changeEnquiryStatusResponse(response){

	if (response.status == 200) {
		
		viewEnquiryDetail($('#enquiry_id').val());

		$("html").removeClass("flow");
		$("#view_docs_popup").fadeOut();	
		$("#confirm_popup1").fadeOut();	

		toastr.success(response.message, '', {
            timeOut: 3000
        });
	}else {
		error = response.responseJSON.message;
		toastr.error(error, '', {
			timeOut: 3000
		});
	}
}


function backToList(){
	getEnquiriesPageData();
	$('#enquiry_id').val('');
    $(".detail_section").hide();
    $(".listing_section").show(1000);
}

$(document).ready(function () {

    getEnquiriesPageData();
    
    $("#deliveries [name]").prop('disabled', true);
});

$(window).on("load", function() {
	$(".head_lst > li:nth-child(1)").addClass("current");
	li = $('.head_lst > li:first');
	$(document).on("click", ".next_btn", function() {
		li = li.next('li');
		li.prev().removeClass("current");
		li.addClass("current");
	});
	$(document).on("click", ".prev_btn", function() {
		li.removeClass("current");
		li.nextAll().removeClass("done");
		li = li.prev("li").addClass("current");
	});
	$(document).on("click", ".damage_btn .site_btn", function() {
		$(".damage_btn .site_btn").removeClass("active");
		$(this).addClass("active");
	});
});

$('#searchInListing').on("keyup", function (e)  {     
    var tr = $('.identify');
    
    if ($(this).val().length >= 1) {//character limit in search box.
        var noElem = true;
        var val = $.trim(this.value).toLowerCase();
        el = tr.filter(function() {
            return $(this).find('.grid-p-searchby').text().toLowerCase().match(val);
        });
        if (el.length >= 1) {
            noElem = false;
        }
        tr.not(el).hide();
		el.fadeIn();
	} else {
		tr.fadeIn();
    }
});

$('#searchInListing1').on("keyup", function (e)  {     
    var tr = $('.identify1');
    
    if ($(this).val().length >= 1) {//character limit in search box.
        var noElem = true;
        var val = $.trim(this.value).toLowerCase();
        el = tr.filter(function() {
            return $(this).find('.grid-p-searchby1').text().toLowerCase().match(val);
        });
        if (el.length >= 1) {
            noElem = false;
        }
        tr.not(el).hide();
		el.fadeIn();
	} else {
		tr.fadeIn();
    }
});
