<?php use Carbon\Carbon; ?>
@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    .profile {
        padding: 2rem;
    }

    .edit-profile .card {
        border-radius: 5px;
        padding: 15px;
    }

    .card-user .card-image img {
        height: 110px !important;
        object-fit: cover;
    }

    .card-user .card-body {
        min-height: 210px;
        padding: 15px 15px 10px;
    }

    .card-user .author {
        text-align: center;
        text-transform: none;
        font-size: 12px;
        margin-top: -70px;
        font-weight: 600;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .card-user .avatar {
        width: 124px;
        height: 124px;
        border: 5px solid #fff;
        border-color: #eee;
        position: relative;
        margin-bottom: 15px;
        overflow: hidden;
        border-radius: 50%;
        margin-right: 5px;
    }

    .card-user .title {
        line-height: 24px;
    }

    .btn-simple.btn-icon {
        padding: 8px;
    }

    .button-container img {
        width: 18px;
    }

    .edit-profile-icon {
        position: absolute;
        height: 20px;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 33%;
    }

    .card {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }
</style>
<section>


    <div class="tab-content" style="">
        <div id="user_data_tab" class="tab-pane fade in active">
            <div class="profile" style="padding-top: unset;">
                <ul class="crumbs">
                    <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
                    <li>My Account</li>
                </ul>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="edit-profile">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Update Details</h4>
                                </div>
                                <div class="card-body">
                                    <form id="profileform">
                                        <div class="row">
                                            <div class="col-md-12 pr-1">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <p class="form-control" id="useremailformcontainer"
                                                        title="Email can not be changed"></p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-control" placeholder="First Name"
                                                        value="" id="first_name" name="first_name" maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="number" class="form-control" placeholder="Phone Number"
                                                        value="" id="phone_number" name="phone_number" maxlength="18">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group pass_blk">
                                                    <label>Old Password</label>
                                                    <!-- <input type="password" class="form-control text_box"
                                                        placeholder="Old Password" value="" id="old_password"
                                                        name="old_password" maxlength="20"> -->

                                                    <div class="form_blk pass_blk">
                                                        <input type="password" name="old_password" id="old_password"
                                                            class="form-control" placeholder="********"
                                                            autocomplete="false" maxlength="20">
                                                        <i class="icon-eye view_pass" id="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <!-- <input type="password" class="form-control"
                                                        placeholder="New Password" value="" id="password"
                                                        name="password" maxlength="20"> -->

                                                    <div class="form_blk pass_blk">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control" placeholder="********"
                                                            autocomplete="false" maxlength="20">
                                                        <i class="icon-eye view_pass" id="eye"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1">
                                                <div class="form-group">
                                                    <label>Confirm New Password</label>
                                                    <!-- <input type="password" class="form-control"
                                                        placeholder="Confirm New Password" value=""
                                                        id="password_confirmation" name="password_confirmation" maxlength="20"> -->

                                                    <div class="form_blk pass_blk">
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation" class="form-control"
                                                            placeholder="********" autocomplete="false" maxlength="20">
                                                        <i class="icon-eye view_pass" id="eye"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-center " style="margin-top:12px">
                                            <button type="submit" class="site_btn  btn  btn-fill text-center"
                                                id="update_btn">Update</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card card-user">
                            <div class="card-image">
                                <img src="{{asset('assets/images/users/user-background-placeholder.png')}}" alt="...">
                            </div>
                            <div class="card-body">
                                <div class="author" id="uploadImage-edit">
                                    <a href="javascript:;">
                                        @if (Auth::user()->profile_picture !==null)
                                        <img class="avatar border-gray"
                                            src="{{url('/').'/public'.Auth::user()->profile_picture}}" alt="...">
                                        @else
                                        <img class="avatar border-gray"
                                            src="{{asset('assets/images/users/user-placeholder.png')}}" alt="...">
                                        @endif

                                    </a>
                                    <a href="javascript:;">
                                        <h5 class="title" id="user_name_container"></h5>
                                    </a>

                                </div>
                                <input type="file" name="profile" id="profile-img-edit" style="display: none">
                                <p class="description text-center" id="userdetailscontainer">

                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


</section>

@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_myaccount.js') }}"></script>
<script>
    document.getElementById('uploadImage-edit').addEventListener('click', function() {
    // Trigger the hidden file input when the button is clicked
    document.getElementById('profile-img-edit').click();
});
document.getElementById('profile-img-edit').addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    if (file) {
        const type="post";
        const url = "/admin/account/profile";
        const data=new FormData();
        data.append('profile_picture',file)
        SendAjaxRequestToServer(type, url, data, '', getProfileEditResponse, '', '');

    }
    function getProfileEditResponse(response){

        if(response.status==200){
            toastr.success("Profile picture updated successfully",'Updated',{
                "timeOut":3000,
            })
            location.reload();

        }
        else if(response.status==422){
            const err=response.responseJSON.errors;
            const errors=Object.keys(err).map(function(key){
                toastr.error(err[key][0],'Oops!',{
                    "timeOut":3000,
                })
                });
        }

        else{
            toastr.error("Oops! something went wrong",'Oops!',{
                "timeOut":3000,
            })
        }

    }
});
</script>

@endpush
