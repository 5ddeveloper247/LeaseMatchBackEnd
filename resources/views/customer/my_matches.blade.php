
@extends('layouts.master.user_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
</style>

<section id="leasing_dash">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li>My Matches</li>
        </ul>
        <div class="main_row flex_row">
            @if(@count($properties) > 0)
                @foreach($properties as $value)
                    
                    <?php 
                        $property = $value->landlordPersonal;
                        $enquiry_status = isset($value->tenantEnquiryHeader->status) ? $value->tenantEnquiryHeader->status : '';
                        $image = isset($property->propertyImages[0]->path) ? $property->propertyImages[0]->path : asset('assets/images/property_default.jpg'); 
                    ?>
                    
                    <div class="col">
                        <div class="item_blk">
                            
                            <div class="image">
                                <img src="{{$image}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li class="view_property_detail pointer" data-id="{{$property->id}}" title="View Property Detail">
                                            <a><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li>Size: {{@$property->rentalDetail->size_square_feet}}</li>
                                    <li>Bedrooms: {{@$property->rentalDetail->number_of_bedrooms}} </li>
                                    <li>Bathrooms: {{@$property->rentalDetail->number_of_bathrooms}}</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <h5 class="title">
                                    <a class="view_property_detail pointer" data-id="{{$property->id}}" title="View Property Detail">{{@$property->propertyDetail->property_type}} 
                                        @if(in_array($enquiry_status, ['4','6','7','8']))
                                            <span class="notif-icon"></span>
                                        @endif          
                                    </a>
                                </h5>
                                <div class="price"><span>&dollar;{{@$property->rentalDetail->monthly_rent}}</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="" style="width:100%;" >
                    <p class="text-center">No match found...</p>
                </div>
            @endif
            
            
            
        </div>
    </div>
    <form action="{{route('customer.propertyDetail')}}" method="POST" id="detail_form" style="display:none;">
        @csrf
        <input type="text" name="landlord_id" id="landlord_id" value="">
    </form>
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_customer/customjs/script_mymatches.js') }}"></script>
    
@endpush
