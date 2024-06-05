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
            <li>Landlord</li>
        </ul>
        
        <div class="card_row flex_row" >
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
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_count"></div>
                    <strong>Total</strong>
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
        <div class="br"></div>
        <div class="top_head">
            
           
        </div>
        <div class="blk">
            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th width="40">Property Type</th>
                            <th width="40">Appartment Number</th>
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
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_adminlandlord.js') }}"></script>
    
@endpush
