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
            <li>Contact Us</li>
        </ul>
        
        <div class="blk">
            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr class="col-12" style="background-color: #e5e5e5;">
                            <th class="col-1">S.No</th>
                            <th class="col-4">From</th>
                            <th class="col-5">Message</th>
                            <th>Status</th>
                            <th class="col-2">Replied By</th>
                            <th class="col-1">Action</th>
                        </tr>
                    </thead>
                    <tbody id="listing_html">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</section>



@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_admincontactus.js') }}"></script>
    
@endpush
