@extends('layouts.master.admin_template.master')

@push('css')

@endpush

@section('content')
<style>
    #users_table {
        font-size: x-small;
    }

    .bg-success {
        background-color: #008000 !important;
    }
</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li>Contact Us</li>
        </ul>
        <div class="top_head mt-5">
            <h4>Contact Us</h4>
            <div class="form_blk searchInListing">
                <input type="text" id="searchInListing" class="text_box" placeholder="Search here" maxlength="50">
                <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
            </div>
        </div>

        <div class="blk listing_section">
            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr class="col-12" style="background-color: #e5e5e5;">
                            <th class="col-1">S.No</th>
                            <th class="col-4">From</th>
                            <th class="col-5">Message</th>
                            <th class="text-center">Status</th>
                            <th class="col-2 text-center">Replied By</th>
                            <th class="col-1 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="listing_html">

                    </tbody>
                </table>
            </div>
        </div>

        <!--Form for inserting data--->
        <div class="detail_section" style="display:none;">
            <div class="table_dv">
                <div class="table_cell">
                    <div class="contain">
                        <div class="_inner">
                            <button type="button" class="x_btn" onclick="backToList();"></button>
                            <h4>Reply Contact</h4>
                            <form id="addreply_form">
                                <div class="form_row row">
                                    <input type="hidden" id="contact_id" name="contact_id" value="">
                                    <div class="col-sm-6">
                                        <h6><b>Email Address</b></h6>
                                        <div class="form_blk">
                                            <p id="contact_email"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h6><b>Phone Number</b></h6>
                                        <div class="form_blk">
                                            <p id="contact_phone"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6><b>Messsage</b></h6>
                                        <div class="form_blk">
                                            <p id="contact_message"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6><b>Reply Message</b><sup>**</sup>
                                        </h6>
                                        <div class="form_blk">
                                            <textarea name="reply_message" id="reply_message"
                                                class="form-control text_box"
                                                placeholder="Type reply here..."></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="btn_blk">
                                            <button type="button" class="site_btn md auto"
                                                id="contactReply_submit">Save</button>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>



@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_admincontactus.js') }}"></script>

@endpush