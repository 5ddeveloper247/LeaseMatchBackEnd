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
                        <strong>05</strong>
                        <p>Live Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>02</strong>
                        <p>Soon to Expire</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>01</strong>
                        <p>Incomplete Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>207</strong>
                        <p>Advert Views</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>10</strong>
                        <p>Wishlists</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>05</strong>
                        <p>Live Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>02</strong>
                        <p>Soon to Expire</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>01</strong>
                        <p>Incomplete Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>207</strong>
                        <p>Advert Views</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>10</strong>
                        <p>Wishlists</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>05</strong>
                        <p>Live Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>02</strong>
                        <p>Soon to Expire</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>01</strong>
                        <p>Incomplete Adverts</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>207</strong>
                        <p>Advert Views</p>
                    </div>
                </div>
                <div class="col">
                    <div class="inner">
                        <strong>10</strong>
                        <p>Wishlists</p>
                    </div>
                </div>
            </div>
            
            
            
            <!-- <div class="space"></div>
            <div id="featured">
                <h3 class="heading">My LandLoards</h3>
                <div data-id="slick-listing" class="slick-carousel">
                    <div class="item">
                        <div class="item_blk">
                            <div class="image">
                                <img src="{{asset('assets/images/logo-icon.png')}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a></li>
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li><img src="{{asset('assets/images/vector-registered.svg')}}" alt=""> 2017</li>
                                    <li><img src="{{asset('assets/images/vector-cog.svg')}}" alt=""> Manual </li>
                                    <li><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""> 6,000 mi</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <div class="rateYo"></div>
                                <h5 class="title"><a href="vehicle-details.php">Acura Rsx</a></h5>
                                <div class="price"><del>£30,568</del><span>£28,698</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item_blk">
                            <div class="image">
                                <img src="{{asset('assets/images/logo-icon.png')}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a></li>
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li><img src="{{asset('assets/images/vector-registered.svg')}}" alt=""> 2017</li>
                                    <li><img src="{{asset('assets/images/vector-cog.svg')}}" alt=""> Manual </li>
                                    <li><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""> 6,000 mi</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <div class="rateYo"></div>
                                <h5 class="title"><a href="javascript:;">Lexus GS 450h</a></h5>
                                <div class="price"><del>£30,568</del><span>£28,698</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item_blk">
                            <div class="image">
                                <img src="{{asset('assets/images/logo-icon.png')}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a></li>
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li><img src="{{asset('assets/images/vector-registered.svg')}}" alt=""> 2017</li>
                                    <li><img src="{{asset('assets/images/vector-cog.svg')}}" alt=""> Manual </li>
                                    <li><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""> 6,000 mi</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <div class="rateYo"></div>
                                <h5 class="title"><a href="javascript:;">GTA 5 Lowriders DLC</a></h5>
                                <div class="price"><del>£30,568</del><span>£28,698</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item_blk">
                            <div class="image">
                                <img src="{{asset('assets/images/logo-icon.png')}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a></li>
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li><img src="{{asset('assets/images/vector-registered.svg')}}" alt=""> 2017</li>
                                    <li><img src="{{asset('assets/images/vector-cog.svg')}}" alt=""> Manual </li>
                                    <li><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""> 6,000 mi</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <div class="rateYo"></div>
                                <h5 class="title"><a href="javascript:;">Toyota avalon hybrid</a></h5>
                                <div class="price"><del>£30,568</del><span>£28,698</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item_blk">
                            <div class="image">
                                <img src="{{asset('assets/images/logo-icon.png')}}" alt="">
                                <div class="overlay">
                                    <ul class="social_links">
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-link.svg')}}" alt=""></a></li>
                                        <li><a href="javascript:;"><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                                <ul class="menu_list">
                                    <li><img src="{{asset('assets/images/vector-registered.svg')}}" alt=""> 2017</li>
                                    <li><img src="{{asset('assets/images/vector-cog.svg')}}" alt=""> Manual </li>
                                    <li><img src="{{asset('assets/images/vector-dashboard.svg')}}" alt=""> 6,000 mi</li>
                                </ul>
                            </div>
                            <div class="txt">
                                <div class="rateYo"></div>
                                <h5 class="title"><a href="javascript:;">Hyundai santa fe sport</a></h5>
                                <div class="price"><del>£30,568</del><span>£28,698</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            
            
        </div>
    </section>
        

@endsection

@push('script')
    
    <!-- <script src="{{ asset('assets_admin/customjs/script_adminorders.js') }}"></script> -->
    
@endpush
