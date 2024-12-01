@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table {
        font-size: x-small;
    }
</style>

<section id="listing">

    <input type="hidden" name="" id="active_user_id">
    {{-- this id is used to display the detail after clear or reset the search --}}
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li onclick="backToList();" style="cursor:pointer;">User Property Match</li>
        </ul>

        <div class="listing_section">
            <div class="top_head mt-5">
                <h4>User Property Match</h4>
                <div class="form_blk">
                    <input type="text" id="searchInListing1" class="text_box" placeholder="Search here" maxlength="50">
                    <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
                </div>
            </div>
            <div class="blk ">
                <div class="tbl_blk">
                    <table id="users_table" class="table table-responsive">
                        <thead>
                            <tr>
                                <th width="10">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th width="40">Phone Number</th>
                                <th width="40">Total Allowed</th>
                                <th width="40">Total Assigned</th>
                                <th width="40" data-center>Action</th>

                            </tr>
                        </thead>
                        <tbody id="listing_table_body">


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="detail_section" style="display:none;">
            <div class="payment-detail">
                <button type="button" class="x_btn" onclick="backToList();"></button>
                <div class="top-bar-user top-header-payment-details">
                    <div class="detail-image-top">
                        <img src="{{asset('assets/images/users/user-placeholder.png')}}" alt="">
                        <div class="px-2" style="padding-left: 2rem;">
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-user" title="Username"></i>
                                <span class="px-2" id="user_name"></span>
                            </p>
                            <!-- <h5 class="m-0 text-white" id="user_name"></h5> -->
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-envelope" title="Email"></i>
                                <span class="px-2" id="user_email"></span>

                            </p>
                        </div>
                    </div>
                    <div>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-phone" title="Phone Number"></i>
                            <span class="px-2" id="user_phone"></span>
                        </p>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-calendar" title="Date of Birth"></i>
                            <span class="px-2" id="user_dob"></span>
                        </p>
                    </div>
                </div>

                <br>
                <ul class="tab_list">
                    <li class="active"><a href="#Allll" data-toggle="tab">All Landlords</a></li>
                    <li><a href="#AssignAll" data-toggle="tab">Assigned Landlords</a></li>
                </ul>
                <div class="tab-content">
                    <div id="Allll" class="tab-pane fade in active">
                        <div class="contain-fluid">
                            <div class="top_head mt-5">
                                <h4>Search Filter</h4>
                                <div class="form_blk">
                                    <input type="text" name="" id="searchInListing" class="text_box"
                                        placeholder="Search here">
                                    <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}"
                                            alt=""></button>
                                </div>
                            </div>
                            <div class="_inner">
                                <!-- <button type="button" class="x_btn" ></button> -->
                                <h4></h4>
                                <form id="filter_form">
                                    <div class="form_row row">
                                        <input type="hidden" id="user_id" name="user_id" value="">
                                        <div class="col-sm-3">
                                            <h6>Landlord Username</h6>
                                            <div class="form_blk">
                                                <input type="text" name="landlord_username" id="landlord_username"
                                                    class="form-control text_box" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <h6>Landlord Email</h6>
                                            <div class="form_blk">
                                                <input type="text" name="landlord_email" id="landlord_email"
                                                    class="form-control text_box" placeholder="abc@example.com">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <h6>Property Type</h6>
                                            <div class="form_blk">
                                                <select id="property_type" name="property_type" class="text_box "
                                                    data-container="body">
                                                    <option value="">Please choose an option</option>
                                                    <option value="Apartment">Apartment</option>
                                                    <option value="Condo">Condo</option>
                                                    <option value="House">House</option>
                                                    <option value="Studio">Studio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <h6>Rental Type</h6>
                                            <div class="form_blk">
                                                <select id="rental_type" name="rental_type" class="text_box "
                                                    data-container="body">
                                                    <option value="">Please choose an option</option>
                                                    <option value="Furnished">Furnished</option>
                                                    <option value="Unfurnished">Unfurnished</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-md-12 btn_blk form_btn text-right">
                                            <button type="button" class="site_btn"
                                                id="reset_search_filter">Reset</button>

                                            <button type="button" class="site_btn"
                                                id="search_filter_submit">Search</button>


                                        </div>
                                    </div>



                                </form>
                            </div>
                            <br>
                            <div class="blk">
                                <div class="tbl_blk">
                                    <table id="users_table" class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th width="10">#</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Type</th>
                                                <th>Apartment Number</th>
                                                <th>Size</th>
                                                <th>Bedrooms</th>
                                                <th>Bathrooms</th>
                                                <th>Rental Type</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail_listing_table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="AssignAll" class="tab-pane fade">
                        <div class="blk">
                            <div class="tbl_blk">
                                <table id="users_table" class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th width="10">#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Type</th>
                                            <th>Apartment Number</th>
                                            <th>Size</th>
                                            <th>Bedrooms</th>
                                            <th>Bathrooms</th>
                                            <th>Rental Type</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assigned_listing_table">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>

    </div>

    <!-- delete modal start  -->
    <div class="popup sm" id="confirm_popup">
        <div class="table_dv">
            <div class="table_cell">
                <div class="contain">
                    <div class="_inner">
                        <div class="form_row row">
                            <input type="hidden" id="landlord_id" value="">
                            <div class="col-sm-12 col-12" style="text-align: center;">
                                <h5>Are you sure you want to assign this property to this user...!!!</h5>
                            </div>
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <a href="javascript:;" class="site_btn sm close_confirm"
                                        style="background: #ff0505;">No</a>
                                    <a href="javascript:;" class="site_btn sm assign_prop_confirmed" data-id="">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal end  -->
    <!-- delete modal start  -->
    <div class="popup sm" id="confirm_delete_popup">
        <div class="table_dv">
            <div class="table_cell">
                <div class="contain">
                    <div class="_inner">
                        <div class="form_row row">
                            <input type="hidden" id="match_landlord_id" value="">
                            <input type="hidden" id="property_match_id" value="">
                            <div class="col-sm-12 col-12" style="text-align: center;">
                                <h5>Are you sure you want to remove this from assigned landlord...!!!</h5>
                            </div>
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <a href="javascript:;" class="site_btn sm close_delete_confirm"
                                        style="background: #ff0505;">No</a>
                                    <a href="javascript:;" class="site_btn sm delete_assigned_confirmed"
                                        data-id="">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal end  -->

</section>

@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_adminusermatches.js') }}"></script>

@endpush
