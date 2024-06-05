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
								<button type="button" class="eye" title="View Landlord Detail" data-id = "${value.id}"></button>
								<button type="button" class="del" title="Delete Landlord" data-id = "${value.id}"></button>
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

function changestatus(){
    let type = 'POST';
	let url = '/admin/changeStatusLandlord';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', 'submit_button');
}

function changeStatusResponse(response){

	getLandlordPageData();
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
    
    //console.log('success');
	getLandlordPageData();
});