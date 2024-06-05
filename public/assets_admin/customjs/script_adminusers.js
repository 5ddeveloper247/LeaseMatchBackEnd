$('#add_user_btn').click(function () {
    $('#add-user-popup').show();
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
function formatDate(dateString) {
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}


function loadUsersList() {
    let url = '/admin/getAdminUserList';
    let type = 'GET';
    SendAjaxRequestToServer(type, url, '', '', loadUsersListResponse, '', '');
}


function loadUsersListResponse(response) {

    var usersTableBody = $('#users_table_body');
    usersTableBody.empty();
    var users_list = response.data.admin_list;
    var inactive_users = response.data.inactive_users;
    var active_users = response.data.active_users;
    var total_users = users_list.length;
    
    $.each(users_list, function (index, value) {
        

        var html = `<tr>
                                <td class="nowrap">${index + 1}</td>
                                <td>${value.first_name} ${value.middle_name?value.middle_name:''} ${value.last_name?value.last_name:''}</td>
                                <td>${value.email}</td>
                                <td class="nowrap" >${value.phone_number?value.phone_number:''}</td>
                                <td class="nowrap">${formatDate(value.created_at)}</td>
                                <td data-center>
                                    <div class="switch" >
                                        <input type="checkbox" onclick="changestatus(${value.id})" name="status" id="status" ${value.status == '1' ? 'checked' : ''}>
                                        <em></em>
                                    </div>
                                </td>
                               
                                <td class="nowrap" data-center>
                                    <div class="act_btn">
                                        <button type="button" class="edit pop_btn edit_btn"title="Edit"  data-popup="edit-data-popup" data-id = "${value.id}"></button>
                                        <button type="button" class="del pop_btn delete_btn" title="Delete" data-id = "${value.id}" data-popup="delete-data-popup"></button>
                                    </div>
                                </td>
                            </tr>`;
            usersTableBody.append(html);
    });

    $('#total_users').text(total_users);
    $('#inactive_users').text(inactive_users);
    $('#active_users').text(active_users);


}

$('#add_user_form').submit(function (e) {
    e.preventDefault();

    let form = document.getElementById('add_user_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/addUser';
    SendAjaxRequestToServer(type, url, data, '', addUserResponse, '', '.saveuser_btn');


});

function addUserResponse(response) {
    if (response.status == 200) {
        toastr.success(response.message, '', {
            timeOut: 3000
        });

        let form = $('#add_user_form');
        $('#uiBlocker').hide();
        form.trigger("reset");
        loadUsersList();
        $('#close_add_modal_btn').click();
    }

    if (response.status == 402) {

        error = response.message;

    } else {

        error = response.responseJSON.message;
        var is_invalid = response.responseJSON.errors;

        $.each(is_invalid, function (key) {
            // Assuming 'key' corresponds to the form field name
            var inputField = $('[name="' + key + '"]');
            // Add the 'is-invalid' class to the input field's parent or any desired container
            inputField.addClass('is-invalid');

        });
    }
    toastr.error(error, '', {
        timeOut: 3000
    });

}


$(document).on('click', '.delete_btn', function(){
    var del_id = $(this).attr('data-id');
    console.log(del_id);
    $('#delete_confirmed_btn').attr('data-id', del_id);
});

$('#close_delete_modal_btn').click(function(){
    $('.clode_delete_modal_default_btn').click();
    $('#delete_confirmed_btn').attr('data-id', '');
});

$('#delete_confirmed_btn').click(function(){
    var del_id = $(this).attr('data-id');
    let url = '/admin/deleteUser';
    let type = 'POST';
    let data = new FormData();
    data.append('del_id', del_id);
    SendAjaxRequestToServer(type, url, data, '', deleteUserResponse, '', '');

});


function deleteUserResponse(response){
    if (response.status == 200) {
        
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $('#uiBlocker').hide();
        
        loadUsersList();
        $('#close_delete_modal_btn').click();
    }

    if (response.status == 402) {
        $('#close_delete_modal_btn').click();

        error = response.message;

    } else {
        $('#close_delete_modal_btn').click();

        error = response.responseJSON.message;
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}

function changestatus(id){
    
    let url = '/admin/changestatus';
    let type = 'POST';
    let data = new FormData();
    data.append('id', id);
    SendAjaxRequestToServer(type, url, data, '', changeStatusResponse, '', '');


}


function changeStatusResponse(response){
    if (response.status == 200) {
        
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        $('#uiBlocker').hide();
        
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

$(document).on('click','.edit_btn', function(){
    var id = $(this).attr('data-id');

    let url = '/admin/getuserdata';
    let type = 'POST';
    let data = new FormData();
    data.append('id', id);
    SendAjaxRequestToServer(type, url, data, '', getUserdataResponse, '', '');

    
});


function getUserdataResponse(response){
    if (response.status == 200) {
        var user = response.data;
        var menu_controls = user.menu_controls;
       
        $('#uiBlocker').hide();
        $('#user_id').val(user.id);
        $('#first_name_edit').val(user.first_name);
        $('#middle_name_edit').val(user.middle_name);
        $('#last_name_edit').val(user.last_name);
        $('#phone_number_edit').val(user.phone_number);
        $('#email_edit').text(user.email);

        $(".menu-control-chk").prop('checked', false);
        if(menu_controls != null){
            $.each(menu_controls, function (index, value) {
                $("#menu_chk_"+value['menu_id']).prop('checked', true);
            });
        }
    }

    if (response.status == 402) {
        var error = response.message;
        toastr.error(error, '', {
            timeOut: 3000
        });
    } 
    
}


$('#edit_user_form').submit(function(e){
    e.preventDefault();

    let form = document.getElementById('edit_user_form');
    let data = new FormData(form);
    let type = 'POST';
    let url = '/admin/updateUser';
    SendAjaxRequestToServer(type, url, data, '', updateUserResponse, '', '.edituser_btn');
});

function updateUserResponse(response){
    $('#uiBlocker').hide();
    if (response.status == 200) {
        
        toastr.success(response.message, '', {
            timeOut: 3000
        });
        
        
        loadUsersList();
        $('#close_update_modal_default_btn').click();
    }

    if (response.status == 402) {
        // $('#close_update_modal_default_btn').click();

        error = response.message;

    } else {
        // $('#close_update_modal_default_btn').click();

        error = response.responseJSON.message;
    }
    toastr.error(error, '', {
        timeOut: 3000
    });
}



























$(document).ready(function () {

    loadUsersList();
    
});



