function getMatchesPageData(){
    let type = 'POST';
	let url = '/admin/getMatchesPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getMatchesPageDataResponse, '', 'submit_button');
}

function getMatchesPageDataResponse(response){

	var data = response.data;
	var user_list = data['user_list'];
	
    
	makeUserMatchesListing(user_list);
}

function makeUserMatchesListing(user_list){

	var html = '';

	if(user_list.length > 0){
		$.each(user_list, function (index, value) {
			var allowed_prop = value.active_plan != null ? value.active_plan.plan.number_of_matches : '0';
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.first_name}</td>
						<td>${value.email}</td>
						<td class="nowrap" >${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
						<td class="nowrap text-center" >${allowed_prop}</td>
						<td class="nowrap text-center" >${value.user_matches_count}</td>
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_matches_detail" title="View All Matches" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#listing_table_body").html(html);
}


$(document).on('click', '.view_matches_detail', function (e) {
    
    var user_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getMatchesListWrtUser';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', user_id);

	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', viewDetailResponse, '', '.view_matches_detail');
});

function viewDetailResponse(response) {

    var data = response.data;
    var user_detail = data.user_detail;
	var landlord_listing = data.landlord_listing;
	var assigned_match_listing = data.assigned_match_listing;
    
    if(user_detail != null){
		$("#user_id").val(user_detail.id);
        $("#user_name").text(user_detail.first_name);
        $("#user_email").text(user_detail.email);

        $("#user_phone").text(user_detail.personal_info.phone_number);
        $("#user_dob").text(formatDate(user_detail.personal_info.date_of_birth));
    }

    makeUserPropertyListing(landlord_listing);
	makeAssignedPropertyListing(assigned_match_listing);

    $(".listing_section").hide();
    $(".detail_section").show(1000);
}

function makeUserPropertyListing(landlord_listing){

	var html = '';

	if(landlord_listing.length > 0){
        $.each(landlord_listing, function (index, value) {

			html += `<tr class="identify">
						<td class="nowrap grid-p-searchby">${index + 1}</td>
						<td class="grid-p-searchby">${value.full_name}</td>
						<td class="grid-p-searchby">${value.property_detail != null ? value.property_detail.property_type : ''}</td>
						<td class="nowrap grid-p-searchby">${value.property_detail != null ? value.property_detail.appartment_number : ''}</td>
                        <td class="nowrap grid-p-searchby">${value.rental_detail != null ? value.rental_detail.size_square_feet : ''}</td>
                        <td class="nowrap grid-p-searchby">${value.rental_detail != null ? value.rental_detail.number_of_bedrooms : ''}</td>
						<td class="nowrap grid-p-searchby">${value.rental_detail != null ? value.rental_detail.number_of_bathrooms : ''}</td>
						<td class="nowrap grid-p-searchby">${value.rental_detail != null ? value.rental_detail.rental_type : ''}</td>
						<td class="nowrap">
							<div class="act_btn">
								<button class="site_btn assign_prop_confirm" data-id="${value.id}">Add</button>
							</div>
						</td>
					</tr>`;
		});
    }else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}

    $("#detail_listing_table").html(html);
}

function makeAssignedPropertyListing(assigned_match_listing){

	var html = '';

	if(assigned_match_listing.length > 0){
        $.each(assigned_match_listing, function (index, value) {
			var landlord_personal = value.landlord_personal;
			
			html += `<tr class="identify">
						<td class="nowrap grid-p-searchby">${index + 1}</td>
						<td class="grid-p-searchby">${landlord_personal.full_name}</td>
						<td class="grid-p-searchby">${landlord_personal.property_detail != null ? landlord_personal.property_detail.property_type : ''}</td>
						<td class="nowrap grid-p-searchby">${landlord_personal.property_detail != null ? landlord_personal.property_detail.appartment_number : ''}</td>
                        <td class="nowrap grid-p-searchby">${landlord_personal.rental_detail != null ? landlord_personal.rental_detail.size_square_feet : ''}</td>
                        <td class="nowrap grid-p-searchby">${landlord_personal.rental_detail != null ? landlord_personal.rental_detail.number_of_bedrooms : ''}</td>
						<td class="nowrap grid-p-searchby">${landlord_personal.rental_detail != null ? landlord_personal.rental_detail.number_of_bathrooms : ''}</td>
						<td class="nowrap grid-p-searchby">${landlord_personal.rental_detail != null ? landlord_personal.rental_detail.rental_type : ''}</td>
						<td class="nowrap">
							<div class="act_btn">
								<button class="site_btn" data-id="${value.id}" title="Remove" style="color:red;"><b>X</b></button>
							</div>
						</td>
					</tr>`;
		});
    }else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}

    $("#assigned_listing_table").html(html);
}

$(document).on('click', '.assign_prop_confirm', function (e) {
    
    var landlord_id = $(this).attr('data-id');
	$("#landlord_id").val(landlord_id);

	$("html").addClass("flow");
	$("#confirm_popup").fadeIn();	
});

$(document).on('click', '.close_confirm', function (e) {
    
   	$("#landlord_id").val('');
	
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();	
});

$(document).on('click', '.assign_prop_confirmed', function (e) {
    
    var landlord_id = $("#landlord_id").val();
	var user_id = $("#user_id").val();
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/assignLandlordToUser';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', landlord_id);
	data.append('user_id', user_id);

	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', assignLandlordToUserResponse, '', '.view_matches_detail');
});

function assignLandlordToUserResponse(response){
	
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();	

	if (response.status == 200 || response.status == '200') {

		var data = response.data;
		var assigned_match_listing = data.assigned_match_listing;

		makeAssignedPropertyListing(assigned_match_listing);

		toastr.success(response.message, '', {
            timeOut: 3000
        });

	}else{
		toastr.error(response.message, '', {
            timeOut: 3000
        });
	}
}

$(document).on('click', '#search_filter_submit', function (e) {
    
    var user_id = $("#user_id").val();
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/searchLandlordListingAssign';
	let message = '';
	let form = $("#filter_form");
	let data = new FormData(form[0]);
	data.append('user_id', user_id);

	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', searchLandlordListingAssignResponse, '', '#search_filter_submit');
});

function searchLandlordListingAssignResponse(response){
	
	if (response.status == 200 || response.status == '200') {

		var data = response.data;
		var landlord_listing = data.landlord_listing;

		makeUserPropertyListing(landlord_listing);

	}else{
		toastr.error(response.message, '', {
            timeOut: 3000
        });
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

function formatCurrency(amount) {
	return amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}






function backToList(){
    $(".detail_section").hide();
    $(".listing_section").show(1000);
}

$(document).ready(function () {

    getMatchesPageData();
    
    // $("[name]").prop('disabled', true);
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
        tr.not(el).hide().addClass("d-none").removeClass("d-flex");
		el.fadeIn().removeClass("d-none");
	} else {
		tr.fadeIn().removeClass("d-none");
    }
});


