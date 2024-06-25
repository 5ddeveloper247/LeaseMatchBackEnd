function getPaymentsPageData(){
    let type = 'POST';
	let url = '/admin/getPaymentsPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', 'submit_button');
}

function getPaymentsPageDataResponse(response){

	var data = response.data;
	var payment_user_list = data['payment_user_list'];
	
    
	makeUserPaymentListing(payment_user_list);
}

function makeUserPaymentListing(payments_list){

	var html = '';

	if(payments_list.length > 0){
		$.each(payments_list, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.first_name}</td>
						<td>${value.email}</td>
						<td class="nowrap" >${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
						<td class="nowrap text-center" >${value.user_payments_count}</td>
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_payment_detail" title="View All Payments" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#payments_table_body").html(html);
}


$(document).on('click', '.view_payment_detail', function (e) {
    
    var user_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getPaymentListWrtUser';
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
    var payment_list = detail.user_payments;
    var html = '';

    if(detail != null){
        $("#user_name").text(detail.first_name);
        $("#user_email").text(detail.email);

        $("#user_phone").text(detail.personal_info.phone_number);
        $("#user_dob").text(formatDate(detail.personal_info.date_of_birth));

    }

    if(payment_list.length > 0){
        $.each(payment_list, function (index, value) {
			var payment = JSON.parse(value.response);
			var receiptUrl = payment.receipt_url;

			html += `<tr class="identify">
						<td class="nowrap grid-p-searchby">${index + 1}</td>
						<td class="grid-p-searchby">${detail.first_name}</td>
						<td class="grid-p-searchby">${value.plan != null ? value.plan.title : ''}</td>
						<td class="nowrap grid-p-searchby" >${value.transaction_id}</td>
                        <td class="nowrap grid-p-searchby" >${value.amount != null ? formatCurrency(value.amount) : '0.00'}</td>
                        <td class="nowrap grid-p-searchby" >${formatDate(value.date)}</td>
						<td class="nowrap grid-p-searchby" >${value.status}</td>
						<td class="nowrap" data-center>
							<div class="act_btn">
								<a class="copy" href="${receiptUrl}" target="_blank" title="View Payment Receipt"></a>
							</div>
						</td>
					</tr>`;
		});
    }else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}

    $("#payment_list_table").html(html);

    $(".paymentList_section").hide();
    $(".paymentDetail_section").show(1000);
}


function backToList(){
    $(".paymentDetail_section").hide();
    $(".paymentList_section").show(1000);
}

$(document).ready(function () {

    getPaymentsPageData();
    
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


