function getTenantPageData(){
    let type = 'POST';
	let url = '/admin/getTenantPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getTenantPageDataResponse, '', 'submit_button');
}

function getTenantPageDataResponse(response){

	var data = response.data;
	var tenant_list = data['tenant_list'];
	var total_count = data['total'];
	var total_inactive = data['total_inactive'];
	var total_active = data['total_active'];
	
	$("#total_count").text(total_count);
	$("#total_inactive").text(total_inactive);
	$("#total_active").text(total_active);

	makeTenantListing(tenant_list);
}

function makeTenantListing(tenant_list){

	var html = '';

	if(tenant_list.length > 0){
		$.each(tenant_list, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.first_name}</td>
						<td>${value.email}</td>
						<td class="nowrap" >${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
						<td class="nowrap" >${value.personal_info != null ? formatDate(value.personal_info.date_of_birth) : ''}</td>
						<td class="nowrap">${formatDate(value.created_at)}</td>
						<td data-center>
							<div class="switch" >
								<input type="checkbox" onclick="changestatus(${value.id})" ${value.status == '1' ? 'checked' : ''}>
								<em></em>
							</div>
						</td>
						
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_tenant" title="View Tenant Detail" data-id="${value.id}"></button>
								<button type="button" class="del delete_tenant_confirm" title="Delete Tenant" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#tenantListing_html").html(html);
}

function changestatus(tenant_id){
    let type = 'POST';
	let url = '/admin/changeStatusTenant';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id',tenant_id);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', 'submit_button');
}

function changeStatusResponse(response){
	if (response.status == 200 || response.status == '200') {
		
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		getTenantPageData();
	}else{

		toastr.error(response.message, '', {
            timeOut: 3000
        });
	}
}


$(document).on('click', '.delete_tenant_confirm', function (e) {
    var tenant_id = $(this).attr('data-id');

	$(".delete_tenant_confirmed").attr('data-id', tenant_id);

	$("html").addClass("flow");
	$("#confirm_popup").fadeIn();
	
});
$(document).on('click', '.close_confirm', function (e) {
    $(".delete_tenant_confirmed").attr('data-id', '');
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();
});

$(document).on('click', '.delete_tenant_confirmed', function (e) {
    
	var tenant_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/deleteTenant';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', tenant_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', deleteTenantResponse, '', '.delete_tenant_confirmed');
});
function deleteTenantResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		$(".delete_tenant_confirmed").attr('data-id', '');
		$("html").removeClass("flow");
		$("#confirm_popup").fadeOut();
		
		getTenantPageData();
    }
}

$(document).on('click', '.view_tenant', function (e) {
    var tenant_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getSpecificTenantDetail';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', tenant_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getSpecificTenantResponse, '', '.view_landlord');
	
});

function getSpecificTenantResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        var data = response.data;
        var details = data.details;

		$("#listing").hide();
		$("#deliveries").show();

		if(details != null){

			var personalInfo = details.personal_info;
			var residentialInfo = details.residential_info;
			var financialInfo = details.financial_info;
			var rentalInfo = details.rental_info;
			var livingInfo = details.living_info;
			var householdInfo = details.household_info;
			var petInfo = details.pet_info;
			var accomodationInfo = details.accomodation_info;
			var additionalInfo = details.additional_info;
			var legalInfo = details.legal_info;
			var referencesInfo = details.references;
			var additionalNote = details.additional_note;


			$("#user_name").val(details.first_name);
			$("#user_email").val(details.email);
			
			if(personalInfo != null){
				$("#name").val(personalInfo.name);
				$("#email").val(personalInfo.email);
				$("#phone_number").val(personalInfo.phone_number);
				$("#date_of_birth").val(personalInfo.date_of_birth);
			}
			
			if(residentialInfo != null){
				$("#preferred_location").val(residentialInfo.preferred_location);
				$("#preferred_property_type").val(residentialInfo.preferred_property_type);
				$("#min_bedrooms_needed").val(residentialInfo.min_bedrooms_needed);
				$("#min_bathrooms_needed").val(residentialInfo.min_bathrooms_needed);
			}
			
			if(financialInfo != null){
				$("#annual_income").val(financialInfo.annual_income);
				$("#employment_status").val(financialInfo.employment_status);
				$("#employer_name").val(financialInfo.employer_name);
				$("#income_type").val(financialInfo.income_type);
				$("#rental_budget").val(financialInfo.rental_budget);
			}

			if(rentalInfo != null){
				$("#rental_voucher").val(rentalInfo.rental_voucher);
				$("#voucher_type").val(rentalInfo.voucher_type);
				$("#certification_detail").val(rentalInfo.certification_detail);
				$("#certification_expiry").val(rentalInfo.certification_expiry);
			}

			if(livingInfo != null){
				$("#current_address").val(livingInfo.current_address);
				$("#moving_reason").val(livingInfo.moving_reason);
				$("#prev_landlord_contact").val(livingInfo.prev_landlord_contact);
				$("#lease_violation").val(livingInfo.lease_violation);
			}

			if(householdInfo != null){
				$("#household_size").val(householdInfo.household_size);
				$("#number_of_adults").val(householdInfo.number_of_adults);
				$("#number_of_child").val(householdInfo.number_of_children);
			}

			if(petInfo != null){
				$("#has_pets").val(petInfo.has_pets);
				$("#pet_type").val(petInfo.pet_type);
				$("#number_of_pets").val(petInfo.number_of_pets);
				$("#pet_size").val(petInfo.pet_size);
			}

			if(accomodationInfo != null){
				$("#disability").val(accomodationInfo.disability);
				$("#disability_type").val(accomodationInfo.disability_type);
				$("#special_accomodation").val(accomodationInfo.special_accomodation);
			}

			if(additionalInfo != null){
				$("#max_rent_to_pay").val(additionalInfo.max_rent_to_pay);
				$("#preffered_move_in_date").val(additionalInfo.preffered_move_in_date);
				$("#lease_length_preference").val(additionalInfo.lease_length_preference);
			}

			if(legalInfo != null){
				$("#criminal_record").val(legalInfo.criminal_record);
				$("#legal_right").val(legalInfo.legal_right);
			}

			if(referencesInfo != null){
				$("#reference_name").val(referencesInfo.reference_name);
				$("#reference_relationship").val(referencesInfo.reference_relationship);
				$("#contact_information").val(referencesInfo.contact_information);
			}

			if(additionalNote != null){
				$("#general_note").val(additionalNote.general_note);
				$("#work_with_broker").val(additionalNote.work_with_broker);
			}
			

			
			var tenant_docs = details.user_docs;
			var docs_html = '';
			if(tenant_docs.length > 0){
				$.each(tenant_docs, function (index, value) {
					docs_html += `<li id="">
										<div class="thumb">
											<img src="${value.doc_url}" alt="">
										</div>
									</li>`;
						
				});
			}

			$("#tenantDocuments_html").html(docs_html);
		}

		

    }
}



function formatDate(dateString) {
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}

$(document).ready(function () {

    getTenantPageData();

	$("input, select").prop('disabled', true);
});

$(document).on('click', '.backToListing', function (e) {
    $("#listing").show();
	$("#deliveries").hide();
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
})