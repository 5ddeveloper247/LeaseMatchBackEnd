@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
	
    <!-- Dashboard Section -->
    <section id="dash">
        <div class="contain-fluid">
            <ul class="crumbs">
                <li>Dashboard</li>
            </ul>
            
            <div class="block_row flex_row">
                <div class="col">
                    <div class="inner">
                        <strong id="t_admin_user">0</strong>
                        <p>Total Admin Users</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord">0</strong>
                        <p>Total Landlords</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant">0</strong>
                        <p>Total Tenant</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_active_subs">0</strong>
                        <p>Total Active Subscriptions</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_amount_received">$0</strong>
                        <p>Total Payment Received</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_active">0</strong>
                        <p>Landlord Active</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_inactive">0</strong>
                        <p>Landlord InActive</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_available">0</strong>
                        <p>Landlord Available</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_blocked">0</strong>
                        <p>Landlord Blocked</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_booked">0</strong>
                        <p>Landlord Booked</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant_active">0</strong>
                        <p>Tenant Active</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant_inactive">0</strong>
                        <p>Tenant InActive</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_waiting">0</strong>
                        <p>Tenant Waiting Request</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_inprocess">0</strong>
                        <p>Tenant Inprocess Request</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_approved">0</strong>
                        <p>Tenant Approved Request</p>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
        

@endsection

@push('script')
    
    <script src="{{ asset('assets_admin/customjs/script_admindashboard.js') }}"></script>
    
@endpush
