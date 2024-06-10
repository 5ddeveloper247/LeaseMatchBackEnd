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
            <li>User Subscriptions</li>
        </ul>
        
        <div class="blk listing_section">
            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="40">Phone Number</th>
                            <th width="40" >Total Subscriptions</th>
                            <th width="40" data-center>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody id="subscription_table_body">

                   
                    </tbody>
                </table>
            </div>
        </div>
        <div class="detail_section" style="display:none;">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner">
                            <button type="button" class="x_btn" onclick="backToList();"></button>
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
                                        <th>Plan Amount</th>
                                        <th>Duration Days</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody id="subscriptions_list_table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_adminusersubscriptions.js') }}"></script>
    
@endpush
