@extends('layouts.master.admin_template.master')

@push('css')

@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
</style>

<section id="shop_set">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li>Api Setting</li>
        </ul>
        <div class="blk">
            <h4 class="subheading">Api Settings</h4>
            <form action="javascript:;" method="" id="apiSettings_form">
                <div class="form_row row">
                    <div class="col-xs-6">
                        <h6>Secret Key<sup>*</sup></h6>
                        <div class="form_blk">
                            <input type="text" name="secret_key" id="secret_key" class="text_box" value="{{@$apiSettings->secret_key}}" placeholder="Secret Key">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <h6>Publishable Key<sup>*</sup></h6>
                        <div class="form_blk">
                            <input type="text" name="publishable_key" id="publishable_key" class="text_box" value="{{@$apiSettings->publishable_key}}" placeholder="Publishable Key">
                        </div>
                    </div>
                </div>
                <div class="btn_blk form_btn text-right">
                    <button type="button" class="site_btn long" id="saveSettings_btn">Save</button>
                </div>
            </form>
        </div>
        
        
        
    </div>
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_adminapisettings.js') }}"></script>
    
@endpush
