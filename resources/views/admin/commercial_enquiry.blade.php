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
            <li onclick="backToList();" style="cursor:pointer;">Commercial Enquiry</li>
        </ul>
        <div class="listing_section">
            <!-- <ul class="tab_list">
                <li class="active"><a href="#tab1" data-toggle="tab">In Process Enquiries</a></li>
                <li><a href="#tab2" data-toggle="tab">Waiting Enquiries</a></li>
            </ul> -->
            <div class="tab-content">
                <div id="tab1" class="tab-pane fade in active">
                    <div class="top_head mt-5">
                        <h4 class="filter-toggle">
                            <i class="fa fa-arrow-circle-right"></i>&nbsp;
                            Advance Search Filter
                        </h4>
                    </div>
                    <div class="_inner filter-box" style="display:none;">
                        
                        <h4></h4>
                        <form id="filter_form">
                            <div class="form_row row">
                                <div class="col-sm-3">
                                    <h6>Full Name**</h6>
                                    <div class="form_blk">
                                        <input type="text" name="search_full_name" id="search_full_name" class="form-control text_box" placeholder="Full Name">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Business Name**</h6>
                                    <div class="form_blk">
                                        <input type="text" name="search_business_name" id="search_business_name" class="form-control text_box" placeholder="Business Name">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Job Title**</h6>
                                    <div class="form_blk">
                                        <input type="text" name="search_job_title" id="search_job_title" class="form-control text_box" placeholder="Job Title">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Email**</h6>
                                    <div class="form_blk">
                                        <input type="text" name="search_email" id="search_email" class="form-control text_box" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h6>Phone Number**</h6>
                                    <div class="form_blk">
                                        <input type="number" name="search_phone_number" id="search_phone_number" class="form-control text_box" placeholder="Phone Number">
                                    </div>
                                </div>
                                

                                <div class="col-sm-9">
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
                            <table id="listing_table" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th width="10">#</th>
                                        <th>Full Name</th>
                                        <th>Business Name</th>
                                        <th>Job Title</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        
                                        <th width="40"data-center>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="listing_tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>

        <div class="tab-content detail_section" id="deliveries"  style="display:none"><!-- -->
            <button type="button" class="x_btn" onclick="backToList();"></button>

            <div id="Appointment" class="tab-pane fade in active">
                <div class="top_head">
                    <h4>Commercial Enquiry Information</h4>
                    <div id="action_button">

                    </div>
                </div>

                <div class="top-bar-user top-header-payment-details">
                    <div class="detail-image-top">
                        <img src="{{asset('assets/images/users/user-placeholder.png')}}" alt="">
                        <div class="px-2" style="padding-left: 2rem;">
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-user" title="Username"></i>
                                <span class="px-2" id="full_name"></span>
                            </p>
                            <p class="d-flex align-items-center text-white">
                                <i class="fa fa-envelope" title="Email"></i>
                                <span class="px-2" id="enquiry_email"></span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-phone" title="Phone Number"></i>
                            <span class="px-2" id="enquiry_phone"></span>
                        </p>
                        <p class="d-flex align-items-center text-white">
                            <i class="fa fa-building" title="Enquiry Date"></i>
                            <span class="px-2" id="enquiry_date"></span>
                        </p>
                    </div>
                </div>

                <div class="blk">
                    <form action="" method="POST">
                        <input type="hidden" id="enquiry_id" value="">
                        <ul class="head_lst">
                            <li><span>Business Info</span></li>
                            <li><span>Contact Info</span></li>
                            <li><span>Space Requirement</span></li>
                            <li><span>Preffered Lease Term</span></li>
                        </ul>
                        <fieldset>
                            <div class="form_row row">
                                <div class="col-xs-6">
                                    <h6>Business Name<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="business_name" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Industry Sector<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="industry_sector" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Years In Operation<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="years_operation" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Company Website<sup>*</sup></h6>
                                    <div class="form_blk">
                                        <input type="text" id="company_website" name="" class="text_box" placeholder="">
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
                                <div class="col-xs-6">
                                    <h6>Full Name</h6>
                                    <div class="form_blk">
                                        <input type="text" id="full_name1" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Job Title</h6>
                                    <div class="form_blk">
                                        <input type="text" id="job_title" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <h6>Phone Number</h6>
                                    <div class="form_blk">
                                        <input type="text" id="phone_number" name="" class="text_box" placeholder="">
                                    </div>
                                </div>
                                
                                <div class="col-xs-6">
                                    <h6>Email Address</h6>
                                    <div class="form_blk">
                                        <input type="text" id="email_address" name="" class="text_box" placeholder="">
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
                                <div class="col-sm-12">
                                    <h5 class="color">Type of Space Needed:</h5>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="tsn_chk" id="tsn_retail" disabled>
                                            <label for="">Retail</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="tsn_chk" id="tsn_office" disabled>
                                            <label for="">Office</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="tsn_chk" id="tsn_warehouse" disabled>
                                            <label for="">Warehouse</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="tsn_chk" id="tsn_mixeduse" disabled>
                                            <label for="">Mixed-Use</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="tsn_chk" id="tsn_other" disabled>
                                            <label for="">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12" id="other_detail_div" style="display:none;">
                                    <h6>Other Detail:</h6>
                                    <div class="form_blk">
                                        <input type="text" id="tsn_other_text" name="" class="text_box" placeholder="">
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
                                <div class="col-sm-12">
                                    <h5 class="color">Preferred Lease Term:</h5>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="plt_chk" id="plt_short" disabled>
                                            <label for="">Short Term (1-3 Years)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form_blk">
                                        <div class="lbl_btn">
                                            <input type="checkbox" class="plt_chk" id="plt_long" disabled>
                                            <label for="">Long Term (3+ Years)</label>
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
        <!-- <div class="popup sm" id="confirm_popup">
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
        </div> -->
        <!-- delete modal end  -->

        

        

        
    </div>


</section>

@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_admincommercialenquiries.js') }}"></script>

@endpush
