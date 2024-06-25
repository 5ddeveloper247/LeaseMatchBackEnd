function getRequiredDocumentsPageData(){
    let type = 'GET';
	let url = '/admin/getrequired_documentsPageData';
	let message = '';
	let form = '';
	let data = '';
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getrequired_documentsPageDataResponse, '', '');
}

function getrequired_documentsPageDataResponse(response){

	var data = response.data.list;
  
	
	$("#total_count").text(response.data.total);
	$("#total_inactive").text(response.data.inactive);
	$("#total_active").text(response.data.active);

	makeDocumentsListing(data);
}

function makeDocumentsListing(data){

	var html = '';

	if(data.length > 0){
		$.each(data, function (index, value) {
			html += `<tr>
						<td class="nowrap">${index + 1}</td>
						<td>${value.name}</td>
						<td>${value.description}</td>
						<td data-center>
							<div class="switch" >
								<input type="checkbox" onclick="changestatus(${value.id})" ${value.status == '1' ? 'checked' : ''}>
								<em></em>
							</div>
						</td>
						
						<td class="nowrap" data-center>
							<div class="act_btn">
								<button type="button" class="edit edit_document" title="Edit Document Detail" data-id="${value.id}"></button>
								<button type="button" class="del delete_document_confirm" title="Delete Document" data-id="${value.id}"></button>
							</div>
						</td>
					</tr>`;
				
		});
	}else{
		html = `<tr>
					<td colspan="8"><p class="text-center">No record found!</p></td>
				</tr>`;
	}
	$("#documentListing_html").html(html);
}

function changestatus(document_id){
    let type = 'POST';
	let url = '/admin/changeRequiredDocumentStatus';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id',document_id);
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', '');
}

function changeStatusResponse(response){
	if (response.status == 200 || response.status == '200') {
		
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		getRequiredDocumentsPageData();
	}else{

		toastr.error(response.message, '', {
            timeOut: 3000
        });
	}
}

function savenewdocument(){
    let type = 'POST';
	let url = '/admin/add_new_required_document';
	let message = '';
	let form = document.getElementById('add_document_form');
	let data = new FormData(form);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', add_new_required_documentResponse, '', '#save_new_document');
}   
function add_new_required_documentResponse(response){
    
	if (response.status == 200 || response.status == '200') {
		$("html").removeClass("flow");
		$("#add_document_popup").fadeOut();
        $('#add_document_form')[0].reset();

		toastr.success(response.message, '', {
            timeOut: 3000
        });

		getRequiredDocumentsPageData();
	}else{
        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
		toastr.error(error, '', {
            timeOut: 3000
        });
	}
}

$('#add_document_btn').click(function(){
    $('#add_document_form')[0].reset();
    $("html").addClass("flow");
	$("#add_document_popup").fadeIn();
});

$('#close_add_modal_btn').click(function(){
    $('#close_add_modal_btn_default').click();
});

$(document).on('click', '.delete_document_confirm', function (e) {
    var document_id = $(this).attr('data-id');

	$(".delete_document_confirmed").attr('data-id', document_id);

	$("html").addClass("flow");
	$("#confirm_popup").fadeIn();
	
});
$(document).on('click', '.close_confirm', function (e) {
    $(".delete_tenant_confirmed").attr('data-id', '');
	$("html").removeClass("flow");
	$("#confirm_popup").fadeOut();
});

$(document).on('click', '.delete_document_confirmed', function (e) {
    
	var document_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/deleteRequiredDocument';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', document_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', deleteRequiredDocumentResponse, '', '.delete_document_confirmed');
});
function deleteRequiredDocumentResponse(response){
	// SHOWING MESSAGE ACCORDING TO RESPONSE
    if (response.status == 200 || response.status == '200') {
		toastr.success(response.message, '', {
            timeOut: 3000
        });

		$(".delete_tenant_confirmed").attr('data-id', '');
		$("html").removeClass("flow");
		$("#confirm_popup").fadeOut();
		
		getRequiredDocumentsPageData();
    }
}

$(document).on('click', '.edit_document', function(e){

    var document_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/getRequiredDocumentDetails';
	let message = '';
	let form = '';
	let data = new FormData();
	data.append('id', document_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', getRequiredDocumentDetailsResponse, '', '');
});

function getRequiredDocumentDetailsResponse(response){
    if (response.status == 200 || response.status == '200') {
        
        var data = response.data;
		$('#document_id_edit').val(data.id);
		$('#name_edit').val(data.name);
		$('#description_edit').text(data.description);
		$("html").addClass("flow");
		$("#edit_document_popup").fadeIn();
    }
}

$('#edit_document_form').submit(function(e){
    var document_id = $(this).attr('data-id');
	e.preventDefault();
	let type = 'POST';
	let url = '/admin/updateRequiredDocument';
	let message = '';
	let form = document.getElementById('edit_document_form');
	let data = new FormData(form);
	data.append('id', document_id);
	
	// PASSING DATA TO FUNCTION
	SendAjaxRequestToServer(type, url, data, '', updateRequiredDocumentResponse, '', '');
});

function updateRequiredDocumentResponse(response){

    if (response.status == 200 || response.status == '200') {
		$("html").removeClass("flow");
		$("#edit_document_popup").fadeOut();
        $('#edit_document_form')[0].reset();

		toastr.success(response.message, '', {
            timeOut: 3000
        });

		getRequiredDocumentsPageData();
	}else{
        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
		toastr.error(error, '', {
            timeOut: 3000
        });
	}

}

$(document).ready(function () {

    getRequiredDocumentsPageData();
});



