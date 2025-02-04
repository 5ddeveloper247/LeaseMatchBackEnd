


$('#add_user_btn').click(function () {
    $('#add-user-popup').show();
    $('.preview-img').attr('src', '');
    $('.preview-img').remove();
});
// $('#edit_btn').click(function () {
//     $('#edit-manager-popup').show();
// });
$('#closeupdatedmodalbtn').click(function () {
    $('#close_update_modal_default_btn').click();
});
$('#closeaddmodalbtn').click(function () {
    $('#close_add_modal_btn').click();
});

function loadUsersList() {
    let url = '/admin/getTestimonialList';
    let type = 'GET';
    SendAjaxRequestToServer(type, url, '', '', loadUsersListResponse, '', '');
}


function loadUsersListResponse(response) {
    var usersTableBody = $('#users_table_body');
    usersTableBody.empty();

    // Extract data with default fallback to avoid undefined/null errors
    var list = response?.data || [];
    var inactive = response?.inactive || 0;
    var active = response?.active || 0;
    var total = list.length;

    // If user list is empty, show a "No Data Found" row
    if (list.length <= 0) {
        usersTableBody.append(`
            <tr>
                <td colspan="7" class="text-center">No Data Found</td>
            </tr>
        `);
    } else {
        // Populate the table with user data
        $.each(list, function (index, value) {
            var html = `<tr class="identify">
                            <td class="nowrap grid-p-searchby">${index + 1}</td>
                            <td class="grid-p-searchby">${value?.title || "N/A"}</td>
                            <td class="grid-p-searchby">${trimText(value?.name || "N/A", 20)}</td>
                            <td class="nowrap grid-p-searchby">${value?.description || "N/A"}</td>
                            <td class="nowrap grid-p-searchby">${value?.address || "N/A"}</td>
                            <td class="nowrap grid-p-searchby">${value?.rating || "N/A"}</td>
                            <td class="nowrap grid-p-searchby">${formatDate(value?.created_at || "")}</td>
                            <td data-center>
                                <div class="switch">
                                    <input type="checkbox" onclick="changestatus(${value?.id || 0})" name="status" id="status" ${value?.status == '1' ? 'checked' : ''}>
                                    <em></em>
                                </div>
                            </td>
                            <td class="nowrap" data-center>
                                <div class="act_btn">
                                    <button type="button" class="edit pop_btn edit_btn" title="Edit" data-popup="edit-data-popup" data-id="${value?.id || 0}"></button>
                                    <button type="button" class="del pop_btn delete_btn" title="Delete" data-id="${value?.id || 0}" data-popup="delete-data-popup"></button>
                                </div>
                            </td>
                        </tr>`;
            usersTableBody.append(html);
        });
    }

    // Update user counts
    $('#total').text(total);
    $('#inactive').text(inactive);
    $('#active').text(active);
}


$(document).on('click', '#saveuser_btn', function (e) {
    e.preventDefault();
    $('#uiBlocker').show();
    let form = document.getElementById('add_user_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/testimonial/add';
    SendAjaxRequestToServer(type, url, data, '', addUserResponse, '', '');


});

function addUserResponse(response) {
    $('#uiBlocker').hide();

    let error = ""; // Ensure error is always defined

    if (response.status == 200) {
        toastr.success(response.message, '', { timeOut: 3000 });

        let form = $('#add_user_form');
        form.trigger("reset");

        loadUsersList();
        $('#close_add_modal_btn').click();
    }
    else {
        if (response.status == 402) {
            error = response.message;
        }
        else if (response.responseJSON && response.responseJSON.message) {
            error = response.responseJSON.message;
        }
        else {
            error = "Oops! Something went wrong.";
        }

        // Handle form validation errors if they exist
        if (response.responseJSON && response.responseJSON.errors) {
            $.each(response.responseJSON.errors, function (key) {
                var inputField = $('[name="' + key + '"]');
                inputField.addClass('is-invalid'); // Add error class
            });
        }

        toastr.error(error, '', { timeOut: 3000 });
    }
}



$(document).on('click', '.delete_btn', function () {
    var del_id = $(this).attr('data-id');

    $('#delete_confirmed_btn').attr('data-id', del_id);
});

$('#close_delete_modal_btn').click(function () {
    $('.clode_delete_modal_default_btn').click();
    $('#delete_confirmed_btn').attr('data-id', '');
});

$('#delete_confirmed_btn').click(function () {

    $('#uiBlocker').show();
    var del_id = $(this).attr('data-id');
    let url = '/admin/testimonial/delete';
    let type = 'POST';
    let data = new FormData();
    data.append('del_id', del_id);
    SendAjaxRequestToServer(type, url, data, '', deleteUserResponse, '', '');

});


function deleteUserResponse(response) {
    $('#uiBlocker').hide();

    let error = "";
    if (response.status === 200) {
        toastr.success(response.message, '', { timeOut: 3000 });

        loadUsersList();
        $('#close_delete_modal_btn').click();
    }
    else {
        $('#close_delete_modal_btn').click();

        if (response.status === 402) {
            error = response.message;
        }
        else if (response.responseJSON && response.responseJSON.message) {
            error = response.responseJSON.message;
        }
        else {
            error = "Oops! Something went wrong.";
        }

        toastr.error(error, '', { timeOut: 3000 });
    }
}


function changestatus(id) {

    $('#uiBlocker').show();
    let url = '/admin/testimonial/status';
    let type = 'POST';
    let data = new FormData();
    data.append('id', id);
    SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', '');
}


function changeStatusResponse(response) {

    $('#uiBlocker').hide();

    if (response.status == 200) {

        toastr.success(response.message, '', {
            timeOut: 3000
        });

        loadUsersList();
    }

    if (response.status == 402) {
        error = response.message;

    } else {
        error = response.responseJSON.message;
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}


$(document).on('click', '.edit_btn', function (e) {
    var id = $(this).attr('data-id');

    let url = '/admin/testimonial/getdata';
    let type = 'POST';
    let data = new FormData();
    data.append('id', id);
    SendAjaxRequestToServer(type, url, data, '', getUserdataResponse, '', 'submitbutton');
});


function getUserdataResponse(response) {
    $('#uiBlocker').hide();
    // Check if the response has a status property
    if (response && response.status == 200) {
        var testimonial = response.data;

        if (testimonial) {
            var profile_picture = testimonial.path ? base_url + testimonial.path : ''; // Fallback to empty string
            const previewDiv = document.getElementById('preview-edit');

            previewDiv.innerHTML = '';
            if (profile_picture) { // Only create img element if the picture URL is valid
                const img = document.createElement('img');
                img.src = profile_picture;
                img.alt = 'Image Preview';
                img.classList.add('preview-img-edit'); // Add a class to control styling
                // Append the image to the preview div
                previewDiv.appendChild(img);
            } else {
                // Optionally handle the case where no profile picture exists
                previewDiv.innerHTML = '<p>No profile picture available.</p>';
            }

            // Set user data in the form fields
            $('#edit_id').val(testimonial.id || '');
            $('#title_edit').val(testimonial.title || '');
            $('#description_edit').val(testimonial.description || '');
            $('#name_edit').val(testimonial.name || '');
            $('#address_edit').val(testimonial.address || '');
            $('#rating_edit').val(testimonial.rating || '');
            $('#status_edit').prop('checked', function() {
                return testimonial.status == 1;
            });

            // Reset and check menu controls
            $(".menu-control-chk").prop('checked', false);
        } else {
            toastr.error('data not found.', '', { timeOut: 3000 });
        }
    } else if (response.status == 402) {
        // Handle specific error case
        var error = response.message || 'An error occurred.';
        toastr.error(error, '', { timeOut: 3000 });
    } else {
        // Handle unexpected status codes
        toastr.error('Unexpected response status: ' + response.status, '', { timeOut: 3000 });
    }
}



$(document).on('click', '#edituser_btn', function (e) {
    e.preventDefault();
    $('#uiBlocker').show();
    let form = document.getElementById('edit_user_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/updateTestimonial';
    SendAjaxRequestToServer(type, url, data, '', updateUserResponse, '', 'submitButton');
});

function updateUserResponse(response) {
    $('#uiBlocker').hide();
    let error = "";
    if (response.status == 200) {
        toastr.success(response.message, '', { timeOut: 3000 });

        loadUsersList();
        $('#close_update_modal_default_btn').click();
    }
    else if (response.status == 402) {
        error = response.message;
    }
    else if (response.responseJSON && response.responseJSON.message) {
        error = response.responseJSON.message;
    }
    else {
        error = "An unknown error occurred.";
    }

    if (error) {
        toastr.error(error, '', { timeOut: 3000 });
    }
}


$('[name="first_name"], [name="middle_name"], [name="last_name"],[name="first_name_edit"], [name="middle_name_edit"], [name="last_name_edit"]').on('keydown', function (e) {
    var key = e.keyCode || e.which;
    var char = String.fromCharCode(key);
    var controlKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete'];

    // Allow control keys and non-numeric characters
    if (controlKeys.includes(e.key) || !char.match(/[0-9]/)) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
});

$(document).ready(function () {

    loadUsersList();


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



