@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
     @media (max-width: 460px) {
    .filter-box .form_blk .form-control,
    .filter-box .form_blk .text_box {
        width: 100%;
    }

    .filter-box .form_row .col-sm-3,
    .filter-box .form_row .col-sm-6 {
        width: 100%;
        margin-bottom: -9px;
    }
    .btn_blk{
        float: left;
    }
}

</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li onclick="backToList();" style="cursor:pointer;">Enquiry Requests</li>
        </ul>
        <div class="listing_section">
            <ul class="tab_list">
                <li class="active"><a href="#tab1" data-toggle="tab">In Process Enquiries</a></li>
                <li><a href="#tab2" data-toggle="tab">Waiting Enquiries</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab1" class="tab-pane fade in active">
                    <div class="top_head mt-5">
                        <h4 class="filter-toggle">
                            <i class="fa fa-arrow-circle-right"></i>&nbsp;
                            Advance Search Filter
                        </h4>
                    </div>
                    <div class="_inner filter-box" style="display:none;">
                        <!-- <button type="button" class="x_btn" ></button> -->
                        <h4></h4>
                        <form id="filter_form">
                            <div class="form_row row">
                                <div class="col-sm-3">
                                    <h6>Enquiry Type**</h6>
                                    <div class="form_blk">
                                        <select id="search_appRequest" name="search_appRequest" class="text_box " data-container="body">
                                            <option value="">- Select Request Type -</option>
                                            <option value="1">Application Request</option>
                                            <option value="2">Document Upload</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Property Type**</h6>
                                    <div class="form_blk">
                                        <select id="search_propType" name="search_propType" class="text_box " data-container="body">
                                            <option value="">- Select Property Type -</option>
                                            <option value="Apartment">Apartment</option>
                                            <option value="Condo">Condo</option>
                                            <option value="House">House</option>
                                            <option value="Studio">Studio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Enquiry Date**</h6>
                                    <div class="form_blk">
                                        <input type="date" name="search_date" id="search_date" class="form-control text_box">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Status**</h6>
                                    <div class="form_blk">
                                        <select id="search_status" name="search_status" class="text_box " data-container="body">
                                            <option value="">- Select status -</option>
                                            <option value="1">Application requested</option>
                                            <option value="2">Application confirmed</option>
                                            <option value="4">Waiting for doc upload</option>
                                            <option value="5">Document Uploaded</option>
                                            <option value="6">Approved</option>
                                            <option value="7">Returned</option>
                                            <option value="8">Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="btn_blk form_btn text-right">
                                        <button type="button" class="site_btn" id="reset_filter_btn">Reset</button>
                                        <button type="button" class="site_btn" id="search_filter_submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="top_head mt-5">
                        <h4></h4>
                        <div class="form_blk">
                            <input type="text" id="searchInListing" class="text_box" placeholder="Search here" maxlength="50">
                            <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
                        </div>
                    </div>
                    <div class="blk">

                        <div class="tbl_blk">
                            <table id="users_table" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th>Tenant Name</th>
                                        <th>Landlord Name</th>
                                        <th>Enquiry Type</th>
                                        <th>Message</th>
                                        <th class="text-center">Property Type</th>
                                        <th class="text-center">Apartment Number</th>
                                        <th class="text-center">Enquiry Date</th>
                                        <th class="text-center">Status</th>
                                        <th width="40"data-center>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="processlisting_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tab2" class="tab-pane fade">
                    <div class="top_head">
                        <h4>Waiting Enquiries</h4>
                        <div class="form_blk">
                            <input type="text" id="searchInListing1" class="text_box" placeholder="Search here" maxlength="50">
                            <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
                        </div>
                    </div>
                    <div class="blk">
                        <div class="tbl_blk">
                            <table id="users_table" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th>Tenant Name</th>
                                        <th>Landlord Name</th>
                                        <th>Enquiry Type</th>
                                        <th>Message</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Apartment Number</th>
                                        <th class="text-center">Enquiry Date</th>
                                        <th class="text-center">Status</th>
                                        <th width="40"data-center>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="waitinglisting_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-content detail_section" id="deliveries"  style="display:none">
            <button type="button" class="x_btn" onclick="backToList();"></button>

            <div id="Appointment" class="tab-pane fade in active">
                <div class="top_head">
                    <h4>Enquiry Landlord Information</h4>
                    <div id="action_button">

                    </div>
                </div>

                <div class="top-bar-user top-header-payment-details">
                    <div class="detail-image-top">
                        <img src="{{asset('assets/images/users/user-placeholder.png')}}" alt="">
                        <div class="px-2" style="padding-left: 2rem;">
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-user" title="Username"></i>
                                <span class="px-2" id="tenant_name"></span>
                            </p>
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-envelope" title="Tenant Email"></i>
                                <span class="px-2" id="tenant_email"></span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-phone" title="Property Type"></i>
                            <span class="px-2" id="tenant_phone"></span>
                        </p>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-building"title="Property Type"></i>
                            <span class="px-2" id="tenant_propType"></span>
                        </p>
                    </div>
                </div>

                <div class="blk">
                    <form action="" method="POST">
                        <input type="hidden" id="enquiry_id" value="">
                        <ul class="head_lst">
                            <li><span>Personal</span></li>
                            <li><span>Property</span></li>
                            <li><span>Rental</span></li>
                            <li><span>Tenant</span></li>
                            <li><span>Additional Info</span></li>
                        </ul>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Username<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="full_name" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Email<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="email" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Phone Number<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="phone_number" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Company Name<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="company_name" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border" onclick="backToList();">Back to list</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-12">
                                    <h6>Street Address</h6>
                                    <div class="form_blk">
                                        <input type="text" id="street_address" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Apartment/Unit Number:</h6>
                                    <div class="form_blk">
                                        <input type="text" id="appartment_number" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Borough/Neighborhood</h6>
                                    <div class="form_blk">
                                        <input type="text" id="neighbourhood" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Property Type</h6>
                                    <div class="form_blk">
                                        <select id="property_type" name="" class="text_box " data-container="body">
                                            <option value="">Please choose an option</option>
                                            <option value="Apartment">Apartment</option>
                                            <option value="Condo">Condo</option>
                                            <option value="House">House</option>
                                            <option value="Studio">Studio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Units (if multi-unit property)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_units" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Year Built</h6>
                                    <div class="form_blk">
                                        <input type="text" id="year_built" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Year of Last Major Renovation</h6>
                                    <div class="form_blk">
                                        <input type="text" id="major_renovation" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Size (square footage)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="size_square_feet" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Bedrooms</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_bedrooms" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Bathrooms</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_bathrooms" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Type of Rental</h6>
                                    <div class="form_blk">
                                        <select id="rental_type" name="" class="text_box " data-container="body">
                                            <option value="">Please choose an option</option>
                                            <option value="Furnished">Furnished</option>
                                            <option value="Unfurnished">Unfurnished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Monthly Rent (USD)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="monthly_rent" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Security Deposit Requirement (USD)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="security_deposit" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Minimum Lease Duration (Month)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="lease_duration" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Renewal Options</h6>
                                    <div class="form_blk">
                                        <select id="renwal_option" class="text_box " name="" data-container="body">
                                            <option value="">Please choose an option</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Half Yearly">Half Yearly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>List of Amenities</h6>
                                    <div class="form_blk">
                                        <input type="text" id="list_of_amenities" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Special Features</h6>
                                    <div class="form_blk">
                                        <input type="text" id="special_feature" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Ideal Tenant Characteristics</h6>
                                    <div class="form_blk">
                                        <input type="text" id="tenant_characteristics" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Credit Score Range</h6>
                                    <div class="form_blk">
                                        <input type="text" id="credit_score" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Income Requirements</h6>
                                    <div class="form_blk">
                                        <input type="text" id="income_requirements" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Rental History Checks</h6>
                                    <div class="form_blk">
                                        <input type="text" id="rental_history" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-12">
                                    <h6>Special Instructions or Notes</h6>
                                    <div class="form_blk">
                                        <textarea type="text" id="special_note" name="" class="text_box" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="margin-top: 20px;">
                                <h4 class="subheading">Uploaded Photos</h4>
                                <div class="form_row row">
                                    <div class="col-xs-12">
                                        <div class="upload_lst_blk text_box">
                                            <ul class="img_list flex" id="propertyImages_html">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border" onclick="backToList();">Back to list</button>
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                            </div>
                        </fieldset>
                    </form>
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

                                <div class="col-sm-12 col-12" style="text-align: center;">
                                    <h5>Are you sure you want to confirm this application request...!!!</h5>
                                </div>
                                <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                    <div class="btn_blk">
                                        <a href="javascript:;" class="site_btn sm close_enquiry_confirm" style="background: #ff0505;">No</a>
                                        <a href="javascript:;" class="site_btn sm enquiry_confirmed">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete modal end  -->

        <!-- modal to request documents popup start  -->
        <div class="popup md" id="req_doc_popup">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner editor_blk">
                            <button type="button" class="x_btn" id="close_add_modal_btn"></button>
                            <div id="Inspection" class="tab-pane fade active in">

                                <form action="javascript:;" method="" id="required_doc_form">

                                    <fieldset>
                                        <div class="blk">
                                            <h5 class="color">Required Documents</h5>
                                            <div class="form_row row">
                                                <?php
                                                    $reqDocs = getReqDocs();
                                                ?>
                                                @if(count($reqDocs) > 0)
                                                    @foreach($reqDocs as $value)
                                                        <div class="col-sm-12">
                                                            <div class="form_blk">
                                                                <div class="lbl_btn">
                                                                    <input type="checkbox" name="req_docs[]" id="req_docs_chk_{{$value->id}}" value="{{$value->id}}">
                                                                    <label for="req_docs_chk_{{$value->id}}" title="{{$value->description}}">{{$value->name}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            </div>

                                        <div class="btn_blk form_btn text-center">
                                            <button type="button" class="site_btn long md request_doc_submit">Submit</button>
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal to request documents popup end  -->

        <!-- modal to view uploaded docs popup start  -->
        <div class="popup sm" id="view_docs_popup">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner editor_blk">
                            <button type="button" class="x_btn" id="close_add_modal_btn"></button>
                            <div id="Inspection" class="tab-pane fade active in">

                                <form action="javascript:;" method="" id="required_doc_form">

                                    <fieldset>
                                        <div class="blk">
                                            <h5 class="color">Uploaded Documents</h5>
                                            <div class="form_row row" id="uploaded_docs_section"></div>
                                        </div>
                                        <div class="btn_blk form_btn text-center">
                                            <button type="button" class="site_btn small sm changeStatusEnquiry" data-status="8" style="background: #ff0505;">Cancel</button>
                                            <button type="button" class="site_btn small sm changeStatusEnquiry" data-status="7" style="background: #0078b9;">Return</button>
                                            <button type="button" class="site_btn small sm changeStatusEnquiry" data-status="6" style="background: #008000;">Approve</button>
                                        </div>
                                    </fieldset>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal to view uploaded docs popup end  -->

        <!-- cancel modal start  -->
        <div class="popup sm" id="confirm_popup1">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner">
                            <div class="form_row row">

                                <div class="blk" id="return_doc_mark_section" style="display:none;">
                                    <h5 class="color">Mark document to return...</h5>
                                    <div class="form_row row" id="uploaded_docs_section1"></div>
                                </div>
                                <div class="col-sm-12 col-12" style="text-align: center;">
                                    <h5 id="status_confirm_msg">Are you sure you want to confirm this application request...!!!</h5>
                                </div>
                                <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                    <div class="btn_blk">
                                        <a href="javascript:;" class="site_btn sm close_enquiry_confirm1" style="background: #ff0505;">No</a>
                                        <a href="javascript:;" class="site_btn sm " id="changeStatusEnquiryConfirm">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cancel modal end  -->
    </div>


</section>

@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_adminuserenquiries.js') }}"></script>

@endpush
