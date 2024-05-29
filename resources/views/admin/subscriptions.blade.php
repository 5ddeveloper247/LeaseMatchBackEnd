@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
	
    <!-- Plans Section -->
    <section id="plan">
        <div class="contain-fluid">
            <ul class="crumbs">
                <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li>Subscriptions</li>
            </ul>
            <div class="form_row row pricingList_section" style="margin-bottom: 2vw;">
				<div class="col-xs-2">
					<div class="btn_blk form_btn" style="margin-top: 2vw;">
		             	<button class="site_btn block" onclick="addNewReceord();">Add Plan</button>
		          	</div>
				</div>
			</div>
            <div id="slick-pricing" class="slick-carousel pricingList_section">
                @foreach($plans as $key => $plan)
                
                <div class="item">
                    <div class="plan_blk">
                        @if($key == 0)
                            <img src="{{asset('assets/images/plan_01.svg')}}" alt="">
                        @elseif($key == 1)
                            <img src="{{asset('assets/images/plan_02.svg')}}" alt="">
                        @elseif($key == 2)
                            <img src="{{asset('assets/images/plan_03.svg')}}" alt="">
                        @endif
                        
                        <div class="in_blk">
                            <div class="title">
                                <h4>{{$plan->title != null ? $plan->title : 'Tier '.$key+1}}</h4>
                                <span>30 Days</span>
                            </div>
                            <div class="tagline text-center">{{$plan->initial_price != null ? $plan->initial_price : 'N/A'}}</div>
                            <div class="txt">
                                <ul>
                                    @if($plan->directly_contact_flag == 1)
                                        <li>Number of matches as per the Tier {{$key+1}} - {{$plan->number_of_matches}} properties.</li>
                                    @else
                                        <li>Number of matches as per the Tier {{$key+1}} - N/A properties.</li>
                                    @endif
                                    
                                    @if($plan->directly_contact_flag == 1)
                                        <li>Tenant allowed to directly contact with rental/landlord.</li>
                                    @else
                                        <li>Tenant not allowed to directly contact with rental/landlord.</li>
                                    @endif

                                    @if($plan->directly_contact_flag == 1)
                                        <li>Ask lease match to process application on their behalf.</li>
                                    @else
                                        <li>Not allowed to process application on their behalf.</li>
                                    @endif

                                    @if($plan->directly_contact_flag == 1)
                                        <li>They will be informed as to exactly what documents need to be uploaded to process the as an applicant.</li>
                                    @else
                                        <li>They will able to upload document.</li>
                                    @endif
                                    
                                    
                                </ul>
                                <div class="btn_blk">
                                    <a href="javascript:;" onclick="editPricingPlan(1);">Edit Plan</a>
                                </div>
                            </div>
                            <div class="off"><!-- 50% off if price is under £1000 --></div>
                            <div class="price_blk">
                                <div class="price">£{{$plan->monthly_price != null ? $plan->monthly_price : '0.00'}}</div>
                                <span>30 Days</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- <div class="item">
                    <div class="plan_blk">
                        <img src="{{asset('assets/images/plan_01.svg')}}" alt="">
                        <div class="in_blk">
                            <div class="title">
                                <h4>{{$plan->title}}</h4>
                                <span>15 Days</span>
                            </div>
                            <div class="tagline">Up to 50 photos can be uploaded to highlight your car's features</div>
                            <div class="txt">
                                <ul>
                                    <li>Increase your car's visibility by getting it listed at the top of search results</li>
                                    <li>Our search advantage mechanism will help you be more competitive in your search</li>
                                    <li>Make a YouTube video to showcase your car's best features</li>
                                </ul>
                                <div class="btn_blk">
                                    <a href="javascript:;" onclick="editPricingPlan(1);">Edit Plan</a>
                                </div>
                            </div>
                            <div class="off"></div>
                            <div class="price_blk">
                                <div class="price">£12<small>.99</small></div>
                                <span>15 Days</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="plan_blk">
                        <img src="{{asset('assets/images/plan_02.svg')}}" alt="">
                        <div class="in_blk">
                            <div class="title">
                                <h4>Standard</h4>
                                <span>1 Month</span>
                            </div>
                            <div class="tagline">Up to 50 photos can be uploaded to highlight your car's features</div>
                            <div class="txt">
                                <ul>
                                    <li>Increase your car's visibility by getting it listed at the top of search results</li>
                                    <li>Our search advantage mechanism will help you be more competitive in your search</li>
                                    <li>Make a YouTube video to showcase your car's best features</li>
                                </ul>
                                <div class="btn_blk">
                                    <a href="javascript:;" onclick="exitPricingPlan(2);">Edit Plan</a>
                                </div>
                            </div>
                            <div class="off"></div>
                            <div class="price_blk">
                                <div class="price">£18<small>.99</small></div>
                                <span>1 Month</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="plan_blk">
                        <img src="{{asset('assets/images/plan_03.svg')}}" alt="">
                        <div class="in_blk">
                            <div class="title">
                                <h4>Gold</h4>
                                <span>7 Weeks Days</span>
                            </div>
                            <div class="tagline">Up to 50 photos can be uploaded to highlight your car's features</div>
                            <div class="txt">
                                <ul>
                                    <li>Increase your car's visibility by getting it listed at the top of search results</li>
                                    <li>Our search advantage mechanism will help you be more competitive in your search</li>
                                    <li>Make a YouTube video to showcase your car's best features</li>
                                </ul>
                                <div class="btn_blk">
                                    <a href="javascript:;">Edit Plan</a>
                                </div>
                            </div>
                            <div class="off"></div>
                            <div class="price_blk">
                                <div class="price">£24<small>.99</small></div>
                                <span>7 Weeks</span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="item">
                    <div class="plan_blk">
                        <img src="{{asset('assets/images/plan_04.svg')}}" alt="">
                        <div class="in_blk">
                            <div class="title">
                                <h4>Premium</h4>
                                <span>Until Sold</span>
                            </div>
                            <div class="tagline">Up to 50 photos can be uploaded to highlight your car's features</div>
                            <div class="txt">
                                <ul>
                                    <li>Increase your car's visibility by getting it listed at the top of search results</li>
                                    <li>Our search advantage mechanism will help you be more competitive in your search</li>
                                    <li>Your ad will be re-bookable for free for as long as you like, until you sell</li>
                                    <li>Make a YouTube video to showcase your car's best features</li>
                                </ul>
                                <div class="btn_blk">
                                    <a href="?">Buy Now</a>
                                </div>
                            </div>
                            <div class="off">25% off if price is under £1000</div>
                            <div class="price_blk">
                                <div class="price">£35<small>.99</small></div>
                                <span>Until Sold</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

            <!--Form for inserting data--->
            <div class="addPricing_section" style="display:none;">
                <div class="table_dv">
                    <div class="table_cell">
                        <div class="contain">
                            <div class="_inner">
                                <button type="button" class="x_btn" onclick="backToList();"></button>
                                <h4 >Update Package</h4>
                                <div class="form_row row">
                                	
                                	<div class="col-sm-6 offset-sm-6">
										<h6>
											Title<sup>**</sup>
										</h6>
										<div class="form_blk">
											<input type="text" name="package_title" id="package_title" class="text_box" placeholder="Tier 01">
										</div>
									</div>
									<div class="col-sm-6 offset-sm-6">
										<h6>
											Initial Price<sup>**</sup>
										</h6>
										<div class="form_blk">
											<input type="number" name="initial_price" id="initial_price" class="text_box" placeholder="0.00">
										</div>
									</div>
                                    <div class="col-sm-6 offset-sm-6">
										<h6>
											Monthly Price<sup>**</sup>
										</h6>
										<div class="form_blk">
											<input type="number" name="monthly_price" id="monthly_price" class="text_box" placeholder="0.00">
										</div>
									</div>
									<div class="col-sm-6 offset-sm-6">
										<h6>
											Number of matches<sup>**</sup>
										</h6>
										<div class="form_blk">
											<input type="number" name="number_matches" id="number_matches" class="text_box" placeholder="0">
										</div>
									</div>
									
                                  	<div class="col-sm-4">
                                     	<div class="form_blk">
                                         	<div class="lbl_btn">
                                           		<input type="checkbox" name="tenant_directly_contact" id="tenant_directly_contact">
                                              	<label for="tenant_directly_contact">Tenant Directly Contact</label>
                                         	</div>
                                      	</div>
                                   	</div>
                                       <div class="col-sm-4">
                                     	<div class="form_blk">
                                         	<div class="lbl_btn">
                                           		<input type="checkbox" name="process_application" id="process_application">
                                              	<label for="process_application">Process Application</label>
                                         	</div>
                                      	</div>
                                   	</div>
                                       <div class="col-sm-4">
                                     	<div class="form_blk">
                                         	<div class="lbl_btn">
                                           		<input type="checkbox" name="necessary_document" id="necessary_document">
                                              	<label for="necessary_document">Attach Necessary Document</label>
                                         	</div>
                                      	</div>
                                   	</div>
                                 	<div class="col-sm-2">
					                	<div class="btn_blk">
					                    	<a href="javascript:;" class="site_btn md auto" onclick="saveTypes();" tabindex="0">Save</a>
					                 	</div>
					             	</div>
                              	</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    
    <script src="{{ asset('assets_admin/customjs/script_adminsubscription.js') }}"></script>
    
@endpush
