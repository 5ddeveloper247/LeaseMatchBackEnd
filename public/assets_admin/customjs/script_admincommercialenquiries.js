function getCommercialEnquiriesPageData() {
    let type = 'POST';
    let url = '/admin/getCommercialEnquiriesPageData';
    let message = '';
    let form = '';
    let data = '';
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getCommercialEnquiriesPageDataResponse, '', 'submit_button');
}

function getCommercialEnquiriesPageDataResponse(response) {

    var data = response.data;
    var enquiries = data['enquiries'];

    makeCommercialEnquiryListing(enquiries);
}

function makeCommercialEnquiryListing(enquiries) {
    var html = '';

    // Ensure 'enquiries' is an array and has at least one element
    if (Array.isArray(enquiries) && enquiries.length > 0) {
        enquiries.forEach(function (value, index) {
            
            // Safely handle dynamic data rendering and ensure all fields are available
            html += `<tr class="identify">
                        <td class="nowrap grid-p-searchby">${index + 1}</td>
                        <td class="grid-p-searchby" title="${value.full_name}">${trimText(value.full_name || '', 15)}</td>
                        <td class="grid-p-searchby" title="${value.business_name}">${trimText(value.business_name || '', 15)}</td>
                        <td class="grid-p-searchby" title="${value.job_title}">${trimText(value.job_title || '', 15)}</td>
                        <td class="grid-p-searchby" title="${value.email}">${trimText(value.email || '', 15)}</td>
                        <td class="grid-p-searchby" title="${value.phone_number}">${trimText(value.phone_number || '', 15)}</td>
                        
                        <td class="nowrap" data-center>
                            <div class="act_btn">
                                <button type="button" class="eye" onclick="viewEnquiryDetail(${value.id})" title="View Enquiry Detail"></button>
                            </div>
                        </td>
                    </tr>`;
        });
    } else {
        // Handle case where there are no enquiries
        html = `<tr>
                    <td colspan="8"><p class="text-center">No record found!</p></td>
                </tr>`;
    }

    // Append the generated HTML to the table body
    $("#listing_tbody").html(html);
}

$(document).on('click', '#search_filter_submit', function (e) {

    e.preventDefault();
    let type = 'POST';
    let url = '/admin/searchCommercialEnquiryListing';
    let message = '';
    let form = $("#filter_form");
    let data = new FormData(form[0]);

    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', searchCommercialEnquiryListingResponse, '', '#search_filter_submit');
});

function searchCommercialEnquiryListingResponse(response) {
    // SHOWING MESSAGE ACCORDING TO RESPONSE

    if (response.status == 200 || response.status == '200') {
        var data = response.data;
        var enquiries_list = data.enquiries;

        makeCommercialEnquiryListing(enquiries_list);
    } else {
        toastr.error(response.message, '', {
            timeOut: 3000
        });
    }
}

$(document).on('click', '#reset_filter_btn', function (e) {

    let form = $('#filter_form');
    form.trigger("reset");
    getCommercialEnquiriesPageData();
});

function viewEnquiryDetail(enquiry_id) {

    let type = 'POST';
    let url = '/admin/getCommercialEnquiryDetail';
    let message = '';
    let form = '';
    let data = new FormData();
    data.append('id', enquiry_id);

    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(type, url, data, '', getCommercialEnquiryDetailResponse, '', '.view_enquiry_detail');
}

function getCommercialEnquiryDetailResponse(response) {
    // Ensure response is valid and status is 200
    if (response && (response.status == 200 || response.status == '200')) {
        var data = response.data || {};
        var enquiry_detail = data.enquiry_detail || null;
        if (enquiry_detail) {
            
            $("#full_name").text(enquiry_detail.full_name || 'N/A');
            $("#enquiry_email").text(enquiry_detail.email || 'N/A');
            $("#enquiry_phone").text(enquiry_detail.phone_number || 'N/A');
            $("#enquiry_date").text(formatDate(enquiry_detail.created_at) || 'N/A');
            
            // Business Information
            $("#business_name").val(enquiry_detail.business_name || 'N/A');
            $("#industry_sector").val(enquiry_detail.industry_sector || 'N/A');
            $("#years_operation").val(enquiry_detail.year || 'N/A');
            $("#company_website").val(enquiry_detail.company_website || 'N/A');
            
            // Contact Information
            $("#full_name1").val(enquiry_detail.full_name || 'N/A');
            $("#job_title").val(enquiry_detail.job_title || 'N/A');
            $("#phone_number").val(enquiry_detail.phone_number || 'N/A');
            $("#email_address").val(enquiry_detail.email || 'N/A');
            
            // Type of Space Needed
            $(".tsn_chk").prop('checked', false);
            $("#other_detail_div").hide();
            $("#tsn_other_text").val('');
            if(enquiry_detail.type_of_space == 'Retail'){
                $("#tsn_retail").prop('checked', true);
            } else if(enquiry_detail.type_of_space == 'Office'){
                $("#tsn_office").prop('checked', true);
            } else if(enquiry_detail.type_of_space == 'Warehouse'){
                $("#tsn_warehouse").prop('checked', true);
            } else if(enquiry_detail.type_of_space == 'Mixed-Use'){
                $("#tsn_mixeduse").prop('checked', true);
            } else {
                $("#tsn_other").prop('checked', true);
                $("#other_detail_div").show();
                $("#tsn_other_text").val(enquiry_detail.type_of_space);
            }

            // Preffered Lease Term
            $(".plt_chk").prop('checked', false);
            if(enquiry_detail.preferred_lease_term == 'short-term'){
                $("#plt_short").prop('checked', true);
            } else if(enquiry_detail.preferred_lease_term == 'long-term'){
                $("#plt_long").prop('checked', true);
            }
        }

        // first tab active code
        $('.head_lst li').removeClass('current').first().addClass('current');
        $('fieldset').hide().first().show();

        // Show detail section with animation
        $(".listing_section").hide();
        $(".detail_section").show('slow');

    } else {
        console.error('Invalid response or status code not 200.');
    }
}

function backToList() {
    getCommercialEnquiriesPageData();
    $('#enquiry_id').val('');
    $(".detail_section").hide();
    $(".listing_section").show(1000);
}

$(document).ready(function () {

    getCommercialEnquiriesPageData();

    $("#deliveries [name]").prop('disabled', true);
});

$(window).on("load", function () {
    $(".head_lst > li:nth-child(1)").addClass("current");
    li = $('.head_lst > li:first');
    $(document).on("click", ".next_btn", function () {
        li = li.next('li');
        li.prev().removeClass("current");
        li.addClass("current");
    });
    $(document).on("click", ".prev_btn", function () {
        li.removeClass("current");
        li.nextAll().removeClass("done");
        li = li.prev("li").addClass("current");
    });
    $(document).on("click", ".damage_btn .site_btn", function () {
        $(".damage_btn .site_btn").removeClass("active");
        $(this).addClass("active");
    });
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