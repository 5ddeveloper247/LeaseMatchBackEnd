@extends('layouts.master.admin_template.master')

@push('css')
@endpush
<style>
    .top-bar-user{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .top-header-payment-details{
        background-color: #0078b9;
        padding: 10px 25px;
    }
    .top-header-payment-details img{
        height: 80px;
        width: 80px;
        border-radius: 50%;
    }
    .leave-summary{
        border: 1px solid #888;
        border-radius: 5px;
        padding: 5px 10px;
        margin: 15px 0px;
    }
    .leave-summary .label-summary{
        color: black !important;
    }
    .leave-summary .value-summary{
        color: gray;
    }
    .detail-image-top{
        display: flex;
        align-items: center;    
    }
</style>
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
                <div class="top-bar-user top-header-payment-details">
                    <div class="detail-image-top">
                        <img src="{{asset('assets/images/users/5.jpg')}}" alt="">
                        <div class="px-2" style="padding-left: 2rem;">
                            <h5 class="m-0 text-white" id="user_name"></h5>
                            <p class="d-flex align-items-center text-white">
                                <svg class="" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z" />
                                </svg>
                                <span class="px-2" id="user_email"></span>

                            </p>
                        </div>
                    </div>
                    <div>
                        <p class="d-flex align-items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02z" />
                            </svg>
                            <span class="px-2" id="user_phone"></span>
                        </p>
                        <p class="d-flex align-items-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 36 36">
                                <path fill="currentColor" d="M32.25 6H29v2h3v22H4V8h3V6H3.75A1.78 1.78 0 0 0 2 7.81v22.38A1.78 1.78 0 0 0 3.75 32h28.5A1.78 1.78 0 0 0 34 30.19V7.81A1.78 1.78 0 0 0 32.25 6" class="clr-i-outline clr-i-outline-path-1" />
                                <path fill="currentColor" d="M8 14h2v2H8z" class="clr-i-outline clr-i-outline-path-2" />
                                <path fill="currentColor" d="M14 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-3" />
                                <path fill="currentColor" d="M20 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-4" />
                                <path fill="currentColor" d="M26 14h2v2h-2z" class="clr-i-outline clr-i-outline-path-5" />
                                <path fill="currentColor" d="M8 19h2v2H8z" class="clr-i-outline clr-i-outline-path-6" />
                                <path fill="currentColor" d="M14 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-7" />
                                <path fill="currentColor" d="M20 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-8" />
                                <path fill="currentColor" d="M26 19h2v2h-2z" class="clr-i-outline clr-i-outline-path-9" />
                                <path fill="currentColor" d="M8 24h2v2H8z" class="clr-i-outline clr-i-outline-path-10" />
                                <path fill="currentColor" d="M14 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-11" />
                                <path fill="currentColor" d="M20 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-12" />
                                <path fill="currentColor" d="M26 24h2v2h-2z" class="clr-i-outline clr-i-outline-path-13" />
                                <path fill="currentColor" d="M10 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1" class="clr-i-outline clr-i-outline-path-14" />
                                <path fill="currentColor" d="M26 10a1 1 0 0 0 1-1V3a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1" class="clr-i-outline clr-i-outline-path-15" />
                                <path fill="currentColor" d="M13 6h10v2H13z" class="clr-i-outline clr-i-outline-path-16" />
                                <path fill="none" d="M0 0h36v36H0z" />
                            </svg>
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
