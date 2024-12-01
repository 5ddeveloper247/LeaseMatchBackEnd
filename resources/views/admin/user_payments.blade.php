@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li onclick="backToList();" style="cursor:pointer;">User Payments</li>
        </ul>

        <div class="top_head mt-5">
            <h4>User Payments</h4>
            <div class="form_blk" id="searchInListing1">
                <input type="text"  class="text_box" placeholder="Search here" maxlength="50">
                <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
            </div>
        </div>
        <div class="blk paymentList_section">

            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="40">Phone Number</th>
                            <th width="40" >Total Payments</th>
                            <th width="40" data-center>Action</th>

                        </tr>
                    </thead>
                    <tbody id="payments_table_body">


                    </tbody>
                </table>
            </div>
        </div>
        <div class="paymentDetail_section" style="display:none;">
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
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-envelope" title="Email Address"></i>
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
                <!-- <div class="row mx-5">
                    <div class="col-xs-12 col-md-4 my-5">
                        <h3>Leave Summary 2024</h3>
                        <div class="leave-summary">
                            <div class="leave-item">
                                <div class="label-summary">Annual Leave Entitlement Yearly</div>
                                <div class="value-summary">30 Day(s)</div>
                            </div>
                            <div class="leave-item">
                                <div class="label-summary">Availed Annual Leave</div>
                                <div class="value-summary">0 Day(s)</div>
                            </div>
                            <div class="leave-item">
                                <div class="label-summary">Outstanding Annual Leave</div>
                                <div class="value-summary">30 Day(s)</div>
                            </div>
                            <div class="leave-item">
                                <div class="label-summary">Availed Sick Leave</div>
                                <div class="value-summary">0 Day(s)</div>
                            </div>
                            <div class="leave-item">
                                <div class="label-summary">Availed Unpaid Leave</div>
                                <div class="value-summary">0 Day(s)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8">

                    </div>
                </div> -->
                <br>
                <div class="contain-fluid">
                    <div class="top_head mt-5">
                        <h4>All Payments</h4>
                        <div class="form_blk">
                            <input type="text" name="" id="searchInListing" class="text_box" placeholder="Search here">
                            <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
                        </div>
                    </div>
                    <div class="blk">

                        <div class="tbl_blk">
                            <table id="users_table" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th>Username</th>
                                        <th>Plan Name</th>
                                        <th>Transaction ID</th>
                                        <th width="40">Amount</th>
                                        <th>Transaction Date</th>
                                        <th width="40" >Status</th>
                                        <th width="40" >Receipt</th>
                                    </tr>
                                </thead>
                                <tbody id="payment_list_table">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner">
                            <button type="button" class="x_btn" ></button>
                            <h4 >User Details</h4>
                            <form id="viewUser_form">
                                <div class="form_row row">
                                    <input type="hidden" id="plan_id" name="plan_id" value="">
                                    <div class="col-sm-6 offset-sm-6">
                                        <h6>
                                            Name
                                        </h6>
                                        <div class="form_blk">
                                            <input type="text" name="" id="user_name" class="form-control text_box" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 offset-sm-6">
                                        <h6>
                                            Email
                                        </h6>
                                        <div class="form_blk">
                                            <input type="text" name="" id="user_email" class="form-control text_box" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 offset-sm-6">
                                        <h6>
                                            Phone Number
                                        </h6>
                                        <div class="form_blk">
                                            <input type="text" name="" id="user_phone" class="form-control text_box" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 offset-sm-6">
                                        <h6>
                                            Date of birth
                                        </h6>
                                        <div class="form_blk">
                                            <input type="date" name="" id="user_dob" class="form-control text_box" placeholder="">
                                        </div>
                                    </div>



                                </div>
                            </form>

                        </div>
                        <br>
                        <div class="tbl_blk">
                            <button type="button" class="x_btn" onclick="backToList();"></button>
                            <h4 >All Payments</h4>
                            <table id="users_table" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th>Username</th>
                                        <th>Plan Name</th>
                                        <th>Transaction ID</th>
                                        <th width="40">Amount</th>
                                        <th>Transaction Date</th>
                                        <th width="40" >Status</th>
                                        <th width="40" >Receipt</th>
                                    </tr>
                                </thead>
                                <tbody id="payment_list_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>

    </div>
</section>

@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_adminuserpayments.js') }}"></script>

@endpush
