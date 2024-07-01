function getDashboardPageData(){
    
	let type = 'POST';
	let url = '/admin/getDashboardPageData';
	let message = '';
	let form = '';
	let data = '';
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', '#saveSettings_btn');
}
function getDashboardPageDataResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
        
        var data = response.data;
        
        $("#t_admin_user").html(data.total_admins);
        $("#t_landlord").html(data.total_landlords);
        $("#t_tenant").html(data.total_tenants);
        $("#t_active_subs").html(data.total_active_sub);
        $("#t_amount_received").html('&dollar;'+data.total_payment);

        $("#t_landlord_active").html(data.total_landlord_active);
        $("#t_landlord_inactive").html(data.total_landlord_inactive);
        $("#t_landlord_available").html(data.total_landlord_available);
        $("#t_landlord_blocked").html(data.total_landlord_blocked);
        $("#t_landlord_booked").html(data.total_landlord_booked);

        $("#t_tenant_active").html(data.total_tenant_active);
        $("#t_tenant_inactive").html(data.total_tenant_inactive);
        $("#t_request_waiting").html(data.total_request_waiting);
        $("#t_request_inprocess").html(data.total_request_inprocess);
        $("#t_request_approved").html(data.total_request_approved);
    }
}

$(document).ready(function () {
    getDashboardPageData();
});

