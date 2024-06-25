<?php
    use App\Models\TenantEnquiryHeader;
?>
@extends('layouts.master.user_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    } 
</style>

<section id="detail">
    <div class="contain">
        <div class="title_blk">
            <div class="title">
                <h2>Matched Lease: {{@$property_detail->propertyDetail->property_type}}</h2>
                <p class="tagline">Note: {{trimText(@$property_detail->additionalDetail->special_note, 100)}}</p>
            </div>
            <div class="price_blk">
                <div class="price"><span>&dollar;</span>{{@$property_detail->rentalDetail->monthly_rent}}</div>
            </div>
        </div>
        
        <div class="main_row flex_row">
            <div class="col col1">
                <div class="in_col">
                    <div id="detail-slider">
                        <div id="slick-slider" class="slick-carousel">
                            <?php $property_images = $property_detail->propertyImages;?>
                            @if(count($property_images) > 0 )
                                @foreach($property_images as $image)
                                    <div class="img">
                                        <figure data-fancybox="detail" data-href="{{$image->path}}"><img src="{{$image->path}}" alt=""></figure>
                                    </div>
                                @endforeach
                            @else
                                <div class="img">
                                    <figure data-fancybox="detail" data-href="{{asset('assets/images/property_default.jpg')}}"><img src="{{asset('assets/images/property_default.jpg')}}" alt=""></figure>
                                </div>
                            @endif
                        </div>
                        <div id="slick-thumbs" class="slick-carousel">
                            @if(count($property_images) > 0 )
                                @foreach($property_images as $image)
                                    <div class="thumb">
                                        <figure><img src="{{$image->path}}" alt=""></figure>
                                    </div>
                                @endforeach
                            @else
                                <div class="thumb">
                                    <figure><img src="{{asset('assets/images/property_default.jpg')}}" alt=""></figure>
                                </div>
                            @endif
                        </div>
                    </div>
                    <ul class="tab_list main_tab_list">
                        <li class="active"><a href="#General" data-toggle="tab">Additional Information</a></li>
                        <li><a href="#Features" data-toggle="tab">Rental Information</a></li>
                        <li><a href="#Vehicle" data-toggle="tab">Tenant Information</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="General" class="tab-pane fade in active">
                            <div class="blk content">
                                <h6 class="sub_heading">Special Note</h6>
                                <p>{{@$property_detail->additionalDetail->special_note}}</p>
                            </div>
                        </div>
                        <div id="Features" class="tab-pane fade">
                            <div class="blk content">
                                <h6 class="sub_heading">RENTAL Info</h6>
                                <ul class="icon_lst">
                                    <li><img src="{{asset('assets/images/icon-bath.svg')}}" title="Number of Bathrooms">{{@$property_detail->rentalDetail->number_of_bathrooms}}</li>
                                    
                                    <li><img src="{{asset('assets/images/icon-bedroom.svg')}}" title="Number of Bedrooms">{{@$property_detail->rentalDetail->number_of_bedrooms}}</li>
                                    <li><img src="{{asset('assets/images/icon-house.svg')}}" title="Type of Rental">{{@$property_detail->rentalDetail->rental_type}}</li>
                                    <li><img src="{{asset('assets/images/icon-monthly-rent.svg')}}" title="Monthly Rent (USD)">&dollar;{{@$property_detail->rentalDetail->monthly_rent}}</li>
                                    <li><img src="{{asset('assets/images/icon-dollar-note.svg')}}" title="Security Deposit Requirement (USD)">&dollar;{{@$property_detail->rentalDetail->security_deposit}}</li>
                                    <li><img src="{{asset('assets/images/icon-duration.svg')}}" title="Minimum Lease Duration (Month)">{{@$property_detail->rentalDetail->lease_duration}}</li>
                                    <li><img src="{{asset('assets/images/icon-renew.svg')}}" title="Renewal Options">{{@$property_detail->rentalDetail->renwal_option}}</li>
                                    <li><img src="{{asset('assets/images/icon-amenities.svg')}}" title="List of Amenities">{{@$property_detail->rentalDetail->list_of_amenities}}</li>
                                    <li><img src="{{asset('assets/images/icon-features.svg')}}" title="Special Features">{{@$property_detail->rentalDetail->special_feature}}</li>
                                </ul>
                            </div>
                        </div>
                        <div id="Vehicle" class="tab-pane fade">
                        <div class="blk content">
                                <h6 class="sub_heading">TENANT INFO</h6>
                                <ul class="icon_lst">
                                    <li><img src="{{asset('assets/images/icon-characteristics.svg')}}" title="Ideal Tenant Characteristics">{{@$property_detail->tenantDetail->tenant_characteristics}}</li>
                                    <li><img src="{{asset('assets/images/icon-credit-score.svg')}}" title="Credit Score Range">{{@$property_detail->tenantDetail->credit_score}}</li>
                                    <li><img src="{{asset('assets/images/icon-requirements.svg')}}" title="Income Requirements">{{@$property_detail->tenantDetail->income_requirements}}</li>
                                    <li><img src="{{asset('assets/images/icon-history.svg')}}" title="Rental History Checks">{{@$property_detail->tenantDetail->rental_history}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col2">
                <div class="in_col">
                    <h6 class="sub_heading">PROPERTY DETAIL</h6>
                    <ul class="icon_lst">
                        <li><img src="{{asset('assets/images/icon-neighbour.svg')}}" title="Borough/Neighborhood">{{@$property_detail->propertyDetail->neighbourhood}}</li>
                        <li><img src="{{asset('assets/images/icon-property.svg')}}" title="Property Type">{{@$property_detail->propertyDetail->property_type}}</li>
                        <li><img src="{{asset('assets/images/icon-multi-unit.svg')}}" title="Number of Units">{{@$property_detail->propertyDetail->number_of_units}}</li>
                        <li><img src="{{asset('assets/images/icon-build.svg')}}" title="Year Built">{{@$property_detail->propertyDetail->year_built}}</li>
                        <li><img src="{{asset('assets/images/icon-renovation.svg')}}" title="Year of Last Major Renovation">{{@$property_detail->propertyDetail->major_renovation}}</li>
                    </ul>
                    
                    <div class="btn_blk form_btn">
                        <a href="javascript:;" class="site_btn block" id="contact_lanlord_btn" data-id="{{@$property_detail->id}}">Contact Landlord</a>
                    </div>
                    <div class="dealer_blk blk contact_landlord_section" style="filter: blur(5px);">
                        <div class="head text-center">
                            <h4><a href="javascript:;" id="company_name">SQ Lease Group Ltd</a></h4>
                        </div>
                        <hr>
                        <div class="txt">
                            <ul class="sm_lst flex">
                                <li>
                                    <img src="{{asset('assets/images/icon-user.svg')}}" alt="">
                                    <a href="javascript:;" id="landlord_name">John Pie</a>
                                </li>
                                <li>
                                    <img src="{{asset('assets/images/icon-company.svg')}}" alt="">
                                    <a href="javascript:;" id="landlord_company">John Pie</a>
                                </li>
                                <li>
                                    <img src="{{asset('assets/images/symbol-envelope.svg')}}" alt="">
                                    <a href="mailto:example@example.com" id="landlord_email">johnpie@example.com</a>
                                </li>
                                <li>
                                    <img src="{{asset('assets/images/symbol-headphone.svg')}}" alt="">
                                    <a href="tel:(0118) 443 4892" id="landlord_phone">090022334656</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @if(@$enquiry_detail == null)
                        
                        @if($property_detail->enquiry_status != 3)
                            <div class="blk">
                                <h6 class="sub_heading">Process Application Request</h6>
                                <form action="javascript:;" id="processApp_form">
                                    <input type="hidden" name="landlord_id" value="{{@$property_detail->id}}">
                                    @if(@$curr_plan->process_application_flag == 1)
                                        <input type="hidden" name="process_type" value="1">
                                    @elseif(@$curr_plan->necessary_doc_flag == 1)
                                        <input type="hidden" name="process_type" value="2">
                                    @endif
                                    <div class="form_row row">
                                        <div class="col-xs-12">
                                            <h6>Message<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="process_message" id="process_message" class="text_box" placeholder="Message">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn">
                                        <button type="button" class="site_btn block" id="processApp_btn">Process Application</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="blk">
                                    <div class="btn_blk form_btn">
                                        <label><b>Status</b></label>
                                        <button type="button" class="site_btn block">Booked</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        
                    @else
                        @if(@$enquiry_detail->status == '4' || @$enquiry_detail->status == '7')
                            <div class="blk">
                                <h6 class="sub_heading">Upload Documents {{@$enquiry_detail->status == 7 ? 'Again' : ''}}</h6>
                                <form action="javascript:;" id="tenant_enquiry_document_form" enctype="multipart/formdata">
                                    
                                    <input type="hidden" id="enquiry_id" name="enquiry_id" value="{{@$enquiry_detail->id}}">
                                    <div class="form_row row">
                                    @foreach(@$upload_documents as $req_doc)
                                    <input type="hidden" name="req_doc_ids[]" value={{$req_doc->id}}>
                                        <div class="col-xs-12">
                                            <h6>Upload {{$req_doc->required_document->name}}<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="file" name="upload_document[]" data-name="{{$req_doc->required_document->name}}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    
                                    <div class="btn_blk form_btn">
                                        <button type="submit" class="site_btn block" id="tenant_enquiry_document_form_submit_btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="blk">
                                    <div class="btn_blk form_btn">
                                        <label><b>Status</b></label>
                                        <button type="button" class="site_btn block">{{@TenantEnquiryHeader::STATUS_LABELS[@$enquiry_detail->status]}}</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endif
                    
                    

                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    
    
</section>

@endsection

@push('script')
    
<script src="{{ asset('assets_customer/customjs/script_mymatches.js') }}"></script>
    
@endpush
