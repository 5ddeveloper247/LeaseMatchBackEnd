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

//my code

// Cancel subscription confirmation
$(document).on("click", ".cancel_subscription_confirm", function (e) {
    var subscription_id = $(this).attr("data-id");
    $(".cancel_subscription_confirmed").attr("data-id", subscription_id);
    $("html").addClass("flow");
    $("#cancel_confirm_popup").fadeIn();
});

$(document).on("click", ".close_cancel_confirm", function (e) {
    $(".cancel_subscription_confirmed").attr("data-id", "");
    $("html").removeClass("flow");
    $("#cancel_confirm_popup").fadeOut();
});

$(document).on("click", ".cancel_subscription_confirmed", function (e) {
    var subscription_id = $(this).attr("data-id");
    e.preventDefault();
    
    // Show loading or disable button
    $(this).prop('disabled', true);
    $(this).text('Processing...');
    
    let type = "POST";
    let url = "/customer/cancelSubscription"; // Updated URL to match routes
    let data = new FormData();
    data.append("id", subscription_id);
    data.append("_token", $('meta[name="csrf-token"]').attr('content'));
    
    // Get cancellation reason if available
    let reason = $("#cancellation_reason").val();
    if (reason) {
        data.append("cancellation_reason", reason);
    }
    
    // PASSING DATA TO FUNCTION
    SendAjaxRequestToServer(
        type,
        url,
        data,
        "",
        cancelSubscriptionResponse,
        "",
        ".cancel_subscription_confirmed"
    );
});

function cancelSubscriptionResponse(response) {
    if (response.status == 200 || response.status == "200") {
        toastr.success(response.message, "", {
            timeOut: 3000,
        });
        window.location.reload();
        
        // Close the popup
        $(".cancel_subscription_confirmed").attr("data-id", "");
        $("html").removeClass("flow");
        $("#cancel_confirm_popup").fadeOut();
        
        // Update the Cancel button to show "Pending"
        $(".cancel_subscription_confirm").text("Pending").addClass("disabled").prop("disabled", true).css({
            "opacity": "0.7",
            "cursor": "not-allowed",
            "pointer-events": "none"
        });
        
        
        // No need to reload the page, we're updating the UI directly
    } else {
        // Re-enable button in case of error
        $(".cancel_subscription_confirmed").prop('disabled', false);
        $(".cancel_subscription_confirmed").text('Yes');
        
        let errorMessage = response.message || "An error occurred while canceling the subscription";
        toastr.error(errorMessage, "", {
            timeOut: 3000,
        });
        $(".cancel_subscription_confirmed").attr("data-id", "");
        $("html").removeClass("flow");
        $("#cancel_confirm_popup").fadeOut();
    }
}

$(document).ready(function () {
    
    //console.log('success');
  
});