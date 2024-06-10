function getSubscriptionsPageData(){
    let type = 'POST';
	let url = '/admin/getSubscriptionsPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', 'submit_button');
}

function getPaymentsPageDataResponse(response){

	var data = response.data;
	var subscriptions_user_list = data['subscriptions_user_list'];
	
    
	makeUserSubscriptionsListing(subscriptions_user_list);
}

function makeUserSubscriptionsListing(subscriptions_list){

	var html = '';

	if(subscriptions_list.length > 0){
		$.each(subscriptions_list, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.first_name}</td>
						<td>${value.email}</td>
						<td class="nowrap" >${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
						<td class="nowrap text-center" >${value.user_subscriptions_count}</td>
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_subscriptions_detail" title="View All Payments" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#subscription_table_body").html(html);
}


$(document).on('click', '.view_subscriptions_detail', function (e) {
    
    var user_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getSubscriptionsListWrtUser';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', user_id);

	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', viewDetailResponse, '', '#save_plan_submit');
	
});

function viewDetailResponse(response) {

    var data = response.data;
    var detail = data.detail;
    var subscriptions_list = detail.user_subscriptions;
    var html = '';

    if(detail != null){
        $("#user_name").val(detail.first_name);
        $("#user_email").val(detail.email);

        $("#user_phone").val(detail.personal_info.phone_number);
        $("#user_dob").val(detail.personal_info.date_of_birth);

    }

    if(subscriptions_list.length > 0){
        $.each(subscriptions_list, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${detail.first_name}</td>
						<td>${value.plan != null ? value.plan.title : ''}</td>
						<td>${value.plan != null ? formatCurrency(value.plan.monthly_price) : '0.00'}</td>
						<td class="nowrap" >${value.duration_days}</td>
                        <td class="nowrap" >${formatDate(value.start_date)}</td>
						<td class="nowrap" >${formatDate(value.end_date)}</td>
					</tr>`;
		});
    }else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}

    $("#subscriptions_list_table").html(html);

    $(".listing_section").hide();
    $(".detail_section").show(1000);
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

    getSubscriptionsPageData();
    
    $("[name]").prop('disabled', true);
});



