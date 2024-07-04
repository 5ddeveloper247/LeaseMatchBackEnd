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
                        <strong id="t_admin_user">{{@$total_admins}}</strong>
                        <p>Total Admin Users</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord">{{@$total_landlords}}</strong>
                        <p>Total Landlords</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant">{{@$total_tenants}}</strong>
                        <p>Total Tenant</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_active_subs">{{@$total_active_sub}}</strong>
                        <p>Total Active Subscriptions</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_amount_received">&dollar;{{@$total_payment}}</strong>
                        <p>Total Payment Received</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_active">{{@$total_landlord_active}}</strong>
                        <p>Landlord Active</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_inactive">{{@$total_landlord_inactive}}</strong>
                        <p>Landlord InActive</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_available">{{@$total_landlord_available}}</strong>
                        <p>Landlord Available</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_blocked">{{@$total_landlord_blocked}}</strong>
                        <p>Landlord Blocked</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_landlord_booked">{{@$total_landlord_booked}}</strong>
                        <p>Landlord Booked</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant_active">{{@$total_tenant_active}}</strong>
                        <p>Tenant Active</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_tenant_inactive">{{@$total_tenant_inactive}}</strong>
                        <p>Tenant InActive</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_waiting">{{@$total_request_waiting}}</strong>
                        <p>Tenant Waiting Request</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_inprocess">{{@$total_request_inprocess}}</strong>
                        <p>Tenant Inprocess Request</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_request_approved">{{@$total_request_approved}}</strong>
                        <p>Tenant Approved Request</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_assigned_properties">{{@$total_assigned_properties}}</strong>
                        <p>Total Assigned Properties</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong id="t_unassigned_properties">{{@$total_unassigned_properties}}</strong>
                        <p>Total Unassigned Properties</p>
                    </div>
                </div>
            </div>
            
        </div>
        <br><br>
        <div id="payments_chart" style="width: 100%;height:400px;"></div>

        <br><br>
        <div id="property_register_chart" style="width: 100%;height:400px;"></div>
    </section>
        

@endsection

@push('script')
    
    <script src="{{ asset('assets_admin/customjs/script_admindashboard.js') }}"></script>
    
@endpush
