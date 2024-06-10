function addNewReceord(){
	let form = $('#addPlan_form');
	form.trigger("reset");
    $(".pricingList_section").hide();
    $(".addPricing_section").show(1000);
}
function backToList(){
    $(".addPricing_section").hide();
    $(".pricingList_section").show(1000);
}

function buyPlan(plan_id){
	$("#plan_id").val(plan_id);
    $(".pricingList_section").hide();
    $(".addPricing_section").show(1000);
}


$(document).ready(function () {
    
    //console.log('success');
  
});