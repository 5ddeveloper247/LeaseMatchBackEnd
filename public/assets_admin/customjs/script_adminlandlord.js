function getLandlordPageData(){
    let type = 'POST';
	let url = '/admin/getLandlordPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getLandlordPageDataResponse, '', 'submit_button');
}

function getLandlordPageDataResponse(response){

	var data = response.data;
	var landlord_list = data['landlord_list'];
	var total_count = data['total'];
	var total_inactive = data['total_inactive'];
	var total_active = data['total_active'];
	
	$("#total_count").text(total_count);
	$("#total_inactive").text(total_inactive);
	$("#total_active").text(total_active);

	makeLandlordListing(landlord_list);
}

function makeLandlordListing(landlord_list){

	var html = '';

	if(landlord_list.length > 0){
		$.each(landlord_list, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.full_name}</td>
						<td>${value.email}</td>
						<td class="nowrap" >${value.property_detail.property_type}</td>
						<td class="nowrap" >${value.property_detail.appartment_number}</td>
						<td class="nowrap">${formatDate(value.created_at)}</td>
						<td data-center>
							<div class="switch" >
								<input type="checkbox" onclick="changestatus(${value.id})" ${value.status == '1' ? 'checked' : ''}>
								<em></em>
							</div>
						</td>
						
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_landlord" title="View Landlord Detail" data-id="${value.id}"></button>
								<button type="button" class="del delete_landlord_confirm" title="Delete Landlord" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#landlordListing_html").html(html);
}

function changestatus(landlord_id){
    let type = 'POST';
	let url = '/admin/changeStatusLandlord';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id',landlord_id);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', 'submit_button');
}

function changeStatusResponse(response){
	if (response.status == 200 || response.status == '200') {
		
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		getLandlordPageData();
	}
}


$(document).on('click', '.delete_landlord_confirm', function (e) {
    var landlor_id = $(this).attr('data-id');

	$(".delete_landlord_confirmed").attr('data-id', landlor_id);

	$("html").addClass("flow");
	$("#confirm_popup").fadeIn();
	
});
$(document).on('click', '.close_confirm', function (e) {
    $(".delete_landlord_confirmed").attr('data-id', '');
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();
});

$(document).on('click', '.delete_landlord_confirmed', function (e) {
    
	var landlord_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/deleteLandlord';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', landlord_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', deleteLandlordResponse, '', '.delete_landlord_confirmed');
});
function deleteLandlordResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		$(".delete_landlord_confirmed").attr('data-id', '');
		$("html").removeClass("flow");
		$("#confirm_popup").fadeOut();
		
		getLandlordPageData();
    }
}

$(document).on('click', '.view_landlord', function (e) {
    var landlord_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getSpecificLandlordDetail';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', landlord_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getSpecificLandlordResponse, '', '.view_landlord');
	
});

function getSpecificLandlordResponse(response) {

    // SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
      
        var data = response.data;
        var details = data.details;

		console.log(details);

		if(details != null){
			
			var propertydetail = details.property_detail;
			var rentalInfo = details.rental_detail;
			var tenantInfo = details.tenant_detail;
			var additionalInfo = details.additional_detail;

			$("#full_name").val(details.full_name);
			$("#email").val(details.email);
			$("#phone_number").val(details.phone_number);
			$("#company_name").val(details.company_name);
			
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

			var property_images = details.property_images;
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

		$("#listing").hide();
		$("#deliveries").show();

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
    
    getLandlordPageData();

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