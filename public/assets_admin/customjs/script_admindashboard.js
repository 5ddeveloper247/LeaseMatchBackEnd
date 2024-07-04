function getDashboardPageData(){
    
	let type = 'POST';
	let url = '/admin/getDashboardPageData';
	let message = '';
	let form = '';
	let data = '';
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getDashboardPageDataResponse, '', 'submit_button');
}
function getDashboardPageDataResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
        
        var data = response.data;
        
        // $("#t_admin_user").html(data.total_admins);
        // $("#t_landlord").html(data.total_landlords);
        // $("#t_tenant").html(data.total_tenants);
        // $("#t_active_subs").html(data.total_active_sub);
        // $("#t_amount_received").html('&dollar;'+data.total_payment);

        // $("#t_landlord_active").html(data.total_landlord_active);
        // $("#t_landlord_inactive").html(data.total_landlord_inactive);
        // $("#t_landlord_available").html(data.total_landlord_available);
        // $("#t_landlord_blocked").html(data.total_landlord_blocked);
        // $("#t_landlord_booked").html(data.total_landlord_booked);

        // $("#t_tenant_active").html(data.total_tenant_active);
        // $("#t_tenant_inactive").html(data.total_tenant_inactive);
        // $("#t_request_waiting").html(data.total_request_waiting);
        // $("#t_request_inprocess").html(data.total_request_inprocess);
        // $("#t_request_approved").html(data.total_request_approved);

        // $("#t_assigned_properties").html(data.total_assigned_properties);
        // $("#t_unassigned_properties").html(data.total_unassigned_properties);
        
        loadChart(data.chart_days, data.chart_payments);    // payments chart
        loadChart1(data.chart_days, data.chart_properties); // properties chart
    }
}

function loadChart(x_value, y_value){
    
    var x_value_days = Object.values(x_value);
    var y_value_payment = Object.values(y_value);

    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById('payments_chart'));

    // Specify the configuration items and data for the chart
    var option = {
                  title: {
                      text: 'Total Payments (Last 15 days)'
                  },
                  tooltip: {},
                  legend: {
                      data: ['Payments']
                  },
                  xAxis: {
                      data: x_value_days
                  },
                  yAxis: {},
                  series: [
                      {
                          name: 'Payments',
                          type: 'bar',
                          data: y_value_payment,
                          itemStyle: {
                              color: '#04d7e8'
                          }
                      }
                  ]
              };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
}

function loadChart1(x_value, y_value){
    
    var x_value_days = Object.values(x_value);
    var y_value_properties = Object.values(y_value);

    // Initialize the echarts instance based on the prepared dom
    var myChart1 = echarts.init(document.getElementById('property_register_chart'));

    // Specify the configuration items and data for the chart
    var option = {
                  title: {
                      text: 'Total Properties Count (Last 15 days)'
                  },
                  tooltip: {},
                  legend: {
                      data: ['Properties']
                  },
                  xAxis: {
                      data: x_value_days
                  },
                  yAxis: {},
                  series: [
                      {
                          name: 'Properties',
                          type: 'line',
                          data: y_value_properties,
                          itemStyle: {
                              color: '#051855'
                          }
                      }
                  ]
              };

    // Display the chart using the configuration items and data just specified.
    myChart1.setOption(option);
}

$(document).ready(function () {
    getDashboardPageData();
});

