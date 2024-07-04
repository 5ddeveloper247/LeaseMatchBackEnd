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
            <li>Tenant</li>
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
            <form id="filter_form">
                <div class="form_row row">
                    <div class="col-sm-3">
                        <h6>Username**</h6>
                        <div class="form_blk">
                            <input type="text" name="search_username" id="search_username" class="form-control text_box" placeholder="Username" maxlength="50">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Phone Number**</h6>
                        <div class="form_blk">
                            <input type="number" name="search_phonenumber" id="search_phonenumber" class="form-control text_box" placeholder="Phone Number" maxlength="18">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Minimum Bedrooms Needed**</h6>
                        <div class="form_blk">
                            <select id="property_type" name="search_minBedrooms" class="text_box " data-container="body">
                                <option value="">- Select a Minimum Bedrooms Needed -</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Preferred Property Type**</h6>
                        <div class="form_blk">
                            <select id="property_type" name="search_propType" class="text_box " data-container="body">
                                <option value="">- Select a Preferred Property Type -</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Condo">Condo</option>
                                <option value="House">House</option>
                                <option value="Studio">Studio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6>Borough/Location**</h6>
                        <div class="form_blk">
                            <select id="search_boroughLocation" name="search_boroughLocation" class="text_box " data-container="body">
                                <option value="">- Select a Preferred Borough/Location -</option>
                                <option value="Bronx">Bronx</option>
                                <option value="Staten Island">Staten Island</option>
                                <option value="Manhattan">Manhattan</option>
                                <option value="Queens">Queens</option>
                                <option value="Brooklyn">Brooklyn</option>
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
                    <div class="col-sm-6">
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
                            <th>Username</th>
                            <th>Email</th>
                            <th width="40">Phone Number</th>
                            <th width="40">Birth Date</th>
                            <th width="40" >Created Date</th>
                            <th width="40" data-center>Status</th>
                            <th width="40" data-center>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody id="tenantListing_html">

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
                                    <a href="javascript:;" class="site_btn sm delete_tenant_confirmed" data-id="">Yes</a>
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
            <li>Tenant</li>
        </ul>
        <div class="tab-content">
            <div id="Appointment" class="tab-pane fade in active">
                <div class="top_head">
                    <h4>Tenant Information</h4>
                </div>
                
                <div class="blk">
                    <form>
                        <ul class="head_lst">
                            <li><span>Step 1</span></li>
                            <li><span>Step 2</span></li>
                            <li><span>Step 3</span></li>
                            <li><span>Step 4</span></li>
                            <li><span>Step 5</span></li>
                            <li><span>Step 6</span></li>
                            <li><span>Step 7</span></li>
                        </ul>
                        <fieldset>  <!-- step 1 -->
                            <div class="top_head">
                                <h4><b>User Information</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Username</h6>
                                    <div class="form_blk">
                                        <input type="text" id="user_name" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Email</h6>
                                    <div class="form_blk">
                                        <input type="text" id="user_email" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="top_head" style="margin-top: 15px;">
                                <h4><b>Personal Information</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Username</h6>
                                    <div class="form_blk">
                                        <input type="text" id="name" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Date of birth</h6>
                                    <div class="form_blk">
                                        <input type="date" id="date_of_birth" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Personal Email</h6>
                                    <div class="form_blk">
                                        <input type="text" id="email" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Phone Number</h6>
                                    <div class="form_blk">
                                        <input type="text" id="phone_number" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border backToListing">Back to list</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 2 -->
                            <div class="top_head">
                                <h4><b>Residential Preference</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Preferred Borough/Location</h6>
                                    <div class="form_blk">
                                        <select id="preferred_location" class="text_box " data-container="body">
                                            <option value="">- Select a Preferred Borough/Location -</option>
                                            <option value="Bronx">Bronx</option>
                                            <option value="Staten Island">Staten Island</option>
                                            <option value="Manhattan">Manhattan</option>
                                            <option value="Queens">Queens</option>
                                            <option value="Brooklyn">Brooklyn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Preferred Property Type</h6>
                                    <div class="form_blk">
                                        <select id="preferred_property_type" class="text_box " data-container="body">
                                            <option value="">- Select a Preferred Property Type -</option>
                                            <option value="Apartment">Apartment</option>
                                            <option value="Condo">Condo</option>
                                            <option value="House">House</option>
                                            <option value="Studio">Studio</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Minimum Bedrooms Needed</h6>
                                    <div class="form_blk">
                                        <select id="min_bedrooms_needed" class="text_box " data-container="body">
                                            <option value="">- Select a Minimum Bedrooms Needed -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Minimum Bathrooms Needed</h6>
                                    <div class="form_blk">
                                        <select id="min_bathrooms_needed" class="text_box " data-container="body">
                                            <option value="">- Select a Minimum Bathrooms Needed -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="top_head" style="margin-top:15px;">
                                <h4><b>Financial Information</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Annual Income (USD)</h6>
                                    <div class="form_blk">
                                        <select id="annual_income" class="text_box " data-container="body">
                                            <option value="">- Select annual income</option>
                                            <option value="10k_20k">$10,000 - $20,000</option>
                                            <option value="20k_30k">$20,000 - $30,000</option>
                                            <option value="30k_40k">$30,000 - $40,000</option>
                                            <option value="40k_50k">$40,000 - $50,000</option>
                                            <option value="50k_60k">$50,000 - $60,000</option>
                                            <option value="60k_70k">$60,000 - $70,000</option>
                                            <option value="70k_80k">$70,000 - $80,000</option>
                                            <option value="80k_90k">$80,000 - $90,000</option>
                                            <option value="90k_100k">$90,000 - $100,000</option>
                                            <option value="100k+">$100,000+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Employment Status</h6>
                                    <div class="form_blk">
                                        <select id="employment_status" class="text_box " data-container="body">
                                            <option value="">- Select an Employment Status -</option>
                                            <option value="Employed">Employed</option>
                                            <option value="Self Employed">Self Employed</option>
                                            <option value="Retired">Retired</option>
                                            <option value="Student">Student</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Employer Name</h6>
                                    <div class="form_blk">
                                        <input type="text" id="employer_name" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <h6>Type of Income</h6>
                                    <div class="form_blk">
                                        <select id="income_type" class="text_box " data-container="body">
                                            <option value="">- Select a Type of Income -</option>
                                            <option value="Salary">Salary</option>
                                            <option value="Benefits">Benefits</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Maximum rental budget (USD)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="rental_budget" class="text_box" placeholder="">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 3 -->
                            <div class="top_head">
                                <h4><b>Rental Assistance and Certification</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Has Rental Voucher</h6>
                                    <div class="form_blk">
                                        <select id="rental_voucher" class="text_box " data-container="body">
                                            <option selected>- Select a Has Rental Voucher -</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Voucher Type</h6>
                                    <div class="form_blk">
                                        <select id="voucher_type" class="text_box " data-container="body">
                                            <option value="">- Select a Voucher Type -</option>
                                            <option value="Section 8">Section 8</option>
                                            <option value="SOTA">SOTA</option>
                                            <option value="CityFheps">CityFheps</option>
                                            <option value="HASA">HASA</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Certification Details</h6>
                                    <div class="form_blk">
                                        <input type="text" id="certification_detail" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Certification Expiry Date</h6>
                                    <div class="form_blk">
                                        <input type="date" id="certification_expiry" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="top_head" style="margin-top:15px;">
                                <h4><b>Current/Previous Living Situation</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Current Address</h6>
                                    <div class="form_blk">
                                        <input type="text" id="current_address" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Reason for Moving</h6>
                                    <div class="form_blk">
                                        <input type="text" id="moving_reason" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Previous Landlord Contact Information</h6>
                                    <div class="form_blk">
                                        <input type="text" id="prev_landlord_contact" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Lease Violations (if any)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="lease_violation" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 4 -->
                            <div class="top_head">
                                <h4><b>Household Information</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Total Household Size</h6>
                                    <div class="form_blk">
                                        <input type="text" id="household_size" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Adults</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_adults" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Children</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_child" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="top_head" style="margin-top:15px;">
                                <h4><b>Pet Information</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Has Pets</h6>
                                    <div class="form_blk">
                                        <select id="has_pets" class="text_box " data-container="body">
                                            <option value="">- Select a Has Pets -</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Pet Type(s)</h6>
                                    <div class="form_blk">
                                        <input type="text" id="pet_type" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Number of Pets</h6>
                                    <div class="form_blk">
                                        <input type="text" id="number_of_pets" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Pet Size</h6>
                                    <div class="form_blk">
                                        <select id="pet_size" class="text_box " data-container="body">
                                            <option selected>- Select a Pet Size -</option>
                                            <option value="Small">Small</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Large">Large</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 5 -->
                            <div class="top_head">
                                <h4><b>Accessibility & Accommodation Requirements</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Disability</h6>
                                    <div class="form_blk">
                                        <select id="disability" class="text_box " data-container="body">
                                            <option value="">- Select a Disability -</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Type of Disability</h6>
                                    <div class="form_blk">
                                        <input type="text" id="disability_type" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <h6>Special Accommodations Needed</h6>
                                    <div class="form_blk">
                                        <input type="text" id="special_accomodation" class="text_box" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="top_head" style="margin-top:15px;">
                                <h4><b>Additional Preferences & Requirements</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Maximum Rent Willing to Pay</h6>
                                    <div class="form_blk">
                                        <input type="text" id="max_rent_to_pay" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Preferred Move-in Date</h6>
                                    <div class="form_blk">
                                        <input type="date" id="preffered_move_in_date" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Lease Length Preference</h6>
                                    <div class="form_blk">
                                        <select id="lease_length_preference" class="text_box " data-container="body">
                                            <option value="">- Select Lease Length Preference</option>
                                            <option value="6">6 months</option>
                                            <option value="12">12 months</option>
                                            <option value="18">18 months</option>
                                            <option value="24">24 months</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 6 -->
                            <div class="top_head">
                                <h4><b>Legal & Compliance</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-12">
                                    <h6>Criminal Record</h6>
                                    <div class="form_blk">
                                        <select id="criminal_record" class="text_box " data-container="body">
                                            <option value="">- Select a Criminal Record</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <h6>Legal Right to Rent</h6>
                                    <div class="form_blk">
                                        <select id="legal_right" class="text_box " data-container="body">
                                            <option value="">- Select a Legal Right to Rent -</option>
                                            <option value="Citizen">Citizen</option>
                                            <option value="Visa Holder">Visa Holder</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="top_head" style="margin-top:15px;">
                                <h4><b>References</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Reference Name</h6>
                                    <div class="form_blk">
                                        <input type="text" id="reference_name" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Reference Relationship</h6>
                                    <div class="form_blk">
                                        <input type="text" id="reference_relationship" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Reference Contact Information</h6>
                                    <div class="form_blk">
                                        <input type="text" id="contact_information" class="text_box" placeholder="">
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long next_btn">Next</button>
                            </div>
                        </fieldset>
                        <fieldset>  <!-- step 7 -->
                            <div class="top_head">
                                <h4><b>Additional Notes</b></h4>
                            </div>
                            <div class="form_row row">
                                <div class="col-xs-12">
                                    <h6>General Notes</h6>
                                    <div class="form_blk">
                                        <textarea type="text" id="general_note" class="text_box" placeholder=""></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <h6>Are you willing to work with a licensed real estate Broker?</h6>
                                    <div class="form_blk">
                                        <select id="work_with_broker" class="text_box " data-container="body">
                                            <option value="">- Select a Legal Right to Rent -</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="" style="margin-top: 20px;">
                                <h4 class="subheading">Uploaded Documents</h4>
                                <div class="form_row row">
                                    <div class="col-xs-12">
                                        <div class="upload_lst_blk text_box">
                                            <ul class="img_list flex" id="tenantDocuments_html">
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_blk form_btn text-right">
                                <button type="button" class="site_btn long simple border prev_btn">Back</button>
                                <button type="button" class="site_btn long simple border backToListing">Go to list</button>
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
    
<script src="{{ asset('assets_admin/customjs/script_admintenant.js') }}"></script>
    
@endpush
