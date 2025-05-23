function getSubscriptionsPageData() {
    let type = 'POST';
    let url = '/admin/getSubscriptionsPageData';
    let message = '';
    let form = '';
    let data = '';
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getPaymentsPageDataResponse, '', 'submit_button');
}

function getPaymentsPageDataResponse(response) {
    var data = response.data;
    var subscriptions_user_list = data['subscriptions_user_list'];
    makeUserSubscriptionsListing(subscriptions_user_list);
}

function makeUserSubscriptionsListing(subscriptions_list) {
    var html = '';

    if (subscriptions_list.length > 0) {
        $.each(subscriptions_list, function (index, value) {
            html += `<tr>
                        <td class="nowrap">${index + 1}</td>
                        <td>${trimText(value.first_name, 20)}</td>
                        <td>${value.email}</td>
                        <td>${value.active_plan != null ? value.active_plan.plan.title : 'No Active Plan'}</td>
                        <td class="nowrap">${value.personal_info != null ? value.personal_info.phone_number : ''}</td>
                        <td class="nowrap text-center">${value.user_subscriptions_count}</td>
                        <td class="nowrap" data-center>
                            <div class="act_btn">
                                <button type="button" class="eye view_subscriptions_detail" title="View All Payments" data-id="${value.id}"></button>
                            </div>
                        </td>
                    </tr>`;
        });
    } else {
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

    if (detail != null) {
        $("#user_name").text(detail?.first_name);
        $("#user_email").text(detail?.email);

        $("#user_phone").text(detail?.personal_info?.phone_number);
        $("#user_dob").text(formatDate(detail?.personal_info?.date_of_birth));
        $('.searchContainer').hide();

    }

    if (subscriptions_list.length > 0) {
        $.each(subscriptions_list, function (index, value) {
            html += `<tr class="identify">
						<td class="nowrap grid-p-searchby">${index + 1}</td>
						<td class="grid-p-searchby">${detail?.first_name}</td>
						<td class="grid-p-searchby">${value.plan != null ? value.plan.title : ''}</td>
						<td class="grid-p-searchby">${value.plan != null ? formatCurrency(value.plan.monthly_price) : '0.00'}</td>
						<td class="nowrap grid-p-searchby" >${value.duration_days}</td>
                        <td class="nowrap grid-p-searchby" >${formatDate(value.start_date)}</td>
						<td class="nowrap grid-p-searchby" >${formatDate(value.end_date)}</td>
                        <td class="nowrap grid-p-searchby" >${value.cancelled_at !== null ? formatDate(value.cancelled_at) : 'N/A'}</td>
                        <td class="nowrap grid-p-searchby" style="text-transform: capitalize;">${value.status || 'N/A'}</td>
					</tr>`;
        });
    } else {
        html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
    }

    $("#subscriptions_list_table").html(html);

    $(".listing_section").hide();
    $(".detail_section").show(1000);
}


function backToList() {
    $(".detail_section").hide();
    $(".listing_section").show(1000);
    $(".searchContainer").show();
}

$(document).ready(function () {

    getSubscriptionsPageData();

    // $("[name]").prop('disabled', true);
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

$('#searchInListing1').on("keyup", function (e) {
    var tr = $('.identify1');

    if ($(this).val().length >= 1) {//character limit in search box.
        var noElem = true;
        var val = $.trim(this.value).toLowerCase();
        el = tr.filter(function () {
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
$('#searchInListingOne').on("keyup", function() {
    var searchText = $(this).val().toLowerCase();
    console.log('Search text:', searchText);
    
    // Get all table rows (excluding header)
    var rows = $('#users_table tbody tr');
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

