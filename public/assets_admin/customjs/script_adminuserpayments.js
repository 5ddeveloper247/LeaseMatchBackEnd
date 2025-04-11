function getPaymentsPageData() {
    let type = 'POST';
    let url = '/admin/getPaymentsPageData';
    let message = '';
    let form = '';
    let data = '';
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', 'submit_button');
}

function getPaymentsPageDataResponse(response) {

    var data = response.data;
    var payment_user_list = data['payment_user_list'];


    makeUserPaymentListing(payment_user_list);
}

function makeUserPaymentListing(payments_list) {

    var html = '';

    if (payments_list.length > 0) {
        $.each(payments_list, function (index, value) {
            html += `<tr class="identify1">
						<td class="nowrap grid-p-searchby1">${index + 1}</td>
						<td class="grid-p-searchby1">${trimText(value.first_name, 20)}</td>
						<td class="grid-p-searchby1">${value.email}</td>
						<td class="nowrap grid-p-searchby1" >${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
						<td class="nowrap grid-p-searchby1 text-center" >${value.user_payments_count}</td>
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="eye view_payment_detail" title="View All Payments" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;

        });
    } else {
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
    $('#searchInListing1').hide();

    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', viewDetailResponse, '', '#save_plan_submit');

});

function viewDetailResponse(response) {
    var data = response?.data || {};
    var detail = data?.detail || {};
    var payment_list = detail?.user_payments || [];
    var html = '';

    // Handle detail section
    if (Object.keys(detail).length > 0) {
        $("#user_name").text(detail?.first_name || "N/A");
        $("#user_email").text(detail?.email || "N/A");

        $("#user_phone").text(detail?.personal_info?.phone_number || "N/A");
        $("#user_dob").text(formatDate(detail?.personal_info?.date_of_birth || ""));
    } else {
        $("#user_name").text("N/A");
        $("#user_email").text("N/A");
        $("#user_phone").text("N/A");
        $("#user_dob").text("N/A");
    }

    // Handle payment list section
    if (payment_list.length > 0) {
        $.each(payment_list, function (index, value) {
            var payment = value?.response ? JSON.parse(value.response) : {};
            console.log("payment", payment)
            var receiptUrl = payment?.latest_invoice?.hosted_invoice_url || payment?.receipt_url || "#";

            html += `<tr class="identify">
                        <td class="nowrap grid-p-searchby">${index + 1}</td>
                        <td class="grid-p-searchby">${trimText(detail?.first_name || "N/A", 20)}</td>
                        <td class="grid-p-searchby">${value?.plan?.title || "N/A"}</td>
                        <td class="nowrap grid-p-searchby">${value?.transaction_id || "N/A"}</td>
                        <td class="nowrap grid-p-searchby">${value?.amount != null ? formatCurrency(value.amount) : "0.00"}</td>
                        <td class="nowrap grid-p-searchby">${formatDate(value?.date || "")}</td>
                        <td class="nowrap grid-p-searchby" style="text-transform: capitalize;">${value?.status === "0" || value?.status === 0 || value?.status === "free" ? "Free" : (value?.status === "active")? "succeeded" : (value?.status || "N/A")}</td>
                        <td class="nowrap" data-center>
                            <div class="act_btn">
                            ${(value?.status !== "0" && value?.status !== 0 && value?.status !== "free") ? 
                                `<a class="copy" href="${receiptUrl}" target="_blank" title="View Payment Receipt"></a>` : 
                                ''}
                            </div>
                        </td>
                    </tr>`;
        });
    } else {
        html = `<tr>
                    <td colspan="8"><p class="text-center">No record found!</p></td>
                </tr>`;
    }

    // Update payment list table
    $("#payment_list_table").html(html);
    // Toggle sections visibility
    $(".paymentList_section").hide();
    $(".paymentDetail_section").show(1000);
}



function backToList() {
    $(".paymentDetail_section").hide();
    $(".paymentList_section").show(1000);
    $('#searchInListing1').show();
}

$(document).ready(function () {

    getPaymentsPageData();

});

$('#searchInListing').on("keyup", function (e) {
    var tr = $('.identify');

    if ($(this).val().length >= 1) {//character limit in search box.
        var noElem = true;
        var val = $.trim(this.value).toLowerCase();
        el = tr.filter(function () {
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

$('#searchInListing1').on("keyup", function(e) {
    
    var searchText = $(this).val().toLowerCase();
    console.log('Search text 11:', searchText);
    
    // Get all table rows (excluding header)
    var rows = $('#users_table_one tbody tr');
    console.log('Total rows found:', rows.length);
    
    if (searchText.length > 0) {
        // For each row
        rows.each(function() {
            var rowText = $(this).text().toLowerCase();
            var shouldShow = rowText.includes(searchText);
            
            // Try using CSS directly instead of jQuery methods
            if (shouldShow) {
                $(this).css('display', '');
            } else {
                $(this).css('display', 'none');
            }
        });
    } else {
        // If search is empty, show all rows
        rows.css('display', '');
    }
});





