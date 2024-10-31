@extends('layouts.master.admin_template.master')

@push('css')

@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }

    input {
        width: 100% !important;
    }
    @media (max-width: 768px) {
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
            <li>Landlord</li>
        </ul>
        
        <div class="card_row flex_row" >
            
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_count"></div>
                    <strong>Total</strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_active"></div>
                    <strong>
                        Active
                    </strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_inactive"></div>
                    <strong>Inactive</strong>
                </div>
            </div>
            
            {{--<div class="col">
                <div class="card_blk">
                    
                </div>
            </div>
            <div class="col">
               <div class="card_blk" id="">
                    
                </div>
            </div>--}}
        </div>
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
                        <h6>Full Name**</h6>
                        <div class="form_blk">
                            <input type="text" name="search_fullname" id="search_fullname" class="form-control text_box" placeholder="Full Name" maxlength="50">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Company Name**</h6>
                        <div class="form_blk">
                            <input type="text" name="search_companyName" id="search_companyName" class="form-control text_box" placeholder="Company Name" maxlength="50">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Bedrooms**</h6>
                        <div class="form_blk">
                            <input type="number" name="search_numBedrooms" id="search_numBedrooms" class="form-control text_box" placeholder="No. of bedrooms" maxlength="3">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Property Type**</h6>
                        <div class="form_blk">
                            <select id="search_propType" name="search_propType" class="text_box " data-container="body">
                                <option value="">- Select a Preferred Property Type -</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Condo">Condo</option>
                                <option value="House">House</option>
                                <option value="Studio">Studio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Type of rental**</h6>
                        <div class="form_blk">
                            <select id="search_rentalType" name="search_rentalType" class="text_box " data-container="body">
                                <option value="">Please choose an option</option>
                                <option value="Furnished">Furnished</option>
                                <option value="Unfurnished">Unfurnished</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Renewal Options**</h6>
                        <div class="form_blk">
                            <select id="search_renewalOption" name="search_renewalOption" class="text_box " data-container="body">
                                <option value="">Please choose an option</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Half Yearly">Half Yearly</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Status**</h6>
                        <div class="form_blk">
                            <select id="search_status" name="search_status" class="text_box " data-container="body">
                                <option value="">- Select status -</option>
                                <option value="1">Active</option>
                                <option value="0">In-Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3">
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
            <div class="tbl_blk tableFixHead">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th width="40">Property Type</th>
                            <th width="40">Apartment Number</th>
                            <th width="40" >Created Date</th>
                            <th width="40" data-center>Status</th>
                            <th width="40" data-center>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody id="landlordListing_html">

                    </tbody>
                </table>
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
                                <h5>Are you sure you want to delete this record...!!!</h5>
                            </div>
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <a href="javascript:;" class="site_btn sm close_confirm" style="background: #ff0505;">No</a>
                                    <a href="javascript:;" class="site_btn sm delete_landlord_confirmed" data-id="">Yes</a>
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

<section id="deliveries" style="display:none;">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li>Landlord</li>
        </ul>
        <div class="tab-content">
            <div id="Appointment" class="tab-pane fade in active">
                <div class="top_head">
                    <h4>Landlord Property Information</h4>
                </div>
                
                <div class="blk">
                    <form action="" method="POST">
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
                                        <input type="text" id="full_name" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Email<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="email" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Phone Number<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="phone_number" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Company Name<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="company_name" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border backToListing">Back to list</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-12">
                                    <h6>Street Address</h6>
                                    <div class="form_blk">
                                        <input type="text" id="street_address" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Apartment/Unit Number:</h6>
                                    <div class="form_blk">
                                        <input type="text" id="appartment_number" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Borough/Neighborhood</h6>
                                    <div class="form_blk">
                                        <input type="text" id="neighbourhood" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Property Type</h6>
                                    <div class="form_blk">
                                        <select id="property_type" class="text_box " data-container="body">
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
                                        <input type="text" id="number_of_units" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Year Built</h6>
                                    <div class="form_blk">
                                        <input type="text" id="year_built" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Year of Last Major Renovation</h6>
                                    <div class="form_blk">
                                        <input type="text" id="major_renovation" class="text_box" placeholder="">
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
                                        <input type="text" id="size_square_feet" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Bedrooms</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_bedrooms" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Bathrooms</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_bathrooms" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Type of Rental</h6>
                                    <div class="form_blk">
                                        <select id="rental_type" class="text_box " data-container="body">
                                            <option value="">Please choose an option</option>
                                            <option value="Furnished">Furnished</option>
                                            <option value="Unfurnished">Unfurnished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Monthly Rent (USD)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="monthly_rent" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Security Deposit Requirement (USD)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="security_deposit" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Minimum Lease Duration (Month)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="lease_duration" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Renewal Options</h6>
                                    <div class="form_blk">
                                        <select id="renwal_option" class="text_box " data-container="body">
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
                                        <input type="text" id="list_of_amenities" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Special Features</h6>
                                    <div class="form_blk">
                                        <input type="text" id="special_feature" class="text_box" placeholder="">
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
                                        <input type="text" id="tenant_characteristics" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Credit Score Range</h6>
                                    <div class="form_blk">
                                        <input type="text" id="credit_score" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Income Requirements</h6>
                                    <div class="form_blk">
                                        <input type="text" id="income_requirements" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Rental History Checks</h6>
                                    <div class="form_blk">
                                        <input type="text" id="rental_history" class="text_box" placeholder="">
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
                                        <textarea type="text" id="special_note" class="text_box" placeholder=""></textarea>
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
                            <button type="button" class="site_btn long simple border backToListing">Go to list</button>
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_adminlandlord.js') }}"></script>
    
@endpush
