<?php use Carbon\Carbon; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lease Match</title>
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}">

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Css Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Favicon -->
    <link type="image/png" rel="icon" href="{{ asset('assets/images/favicon.png') }}">

</head>
<script>
    var base_url = "{{url('/')}}";
</script>

<body data-page="account">
    <div id="uiBlocker"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <img src="{{ asset('assets/images/loading-spinner.gif') }}" alt="Loading..."
                style="height:150px; width:150px;" />
        </div>
    </div>

    @include('layouts.master.user_template.header_guest')

    <main>

        <section id="plan">
            <div class="contain-fluid">
                {{-- <ul class="crumbs">
                    <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                    <li>Subscriptions</li>
                </ul> --}}
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
                                @if($plan->initial_price != null)
                                <div class="tagline text-center" style="font-size: 1.2rem;">Flat initial fee of model -
                                    £{{$plan->initial_price}} this is the fee for all initial memberships.</div>
                                @else
                                <div class="tagline text-center" style="font-size: 1.2rem;">N/A</div>
                                @endif

                                <div class="txt">
                                    <ul>
                                        @if($plan->number_of_matches != null)
                                        <li>Number of matches as per the Tier {{$key+1}} - {{$plan->number_of_matches}}
                                            properties.</li>
                                        @else
                                        <li>Number of matches as per the Tier {{$key+1}} - N/A properties.</li>
                                        @endif

                                        @if($plan->directly_contact_flag == 1)
                                        <li>Tenant allowed to directly contact with rental/landlord.</li>
                                        @else
                                        <li>Tenant not allowed to directly contact with rental/landlord.</li>
                                        @endif

                                        @if($plan->process_application_flag == 1)
                                        <li>Ask lease match to process application on their behalf.</li>
                                        @else
                                        <li>Not allowed to process application on their behalf.</li>
                                        @endif

                                        @if($plan->necessary_doc_flag == 1)
                                        <li>They will be informed as to exactly what documents need to be uploaded to
                                            process the as an applicant.</li>
                                        @else
                                        <li>They will able to upload document.</li>
                                        @endif


                                    </ul>
                                    @if(@$currentPlan->plan_id == $plan->id)
                                    @if(Carbon::now()->format('Y-m-d') > $currentPlan->end_date)
                                    <div class="btn_blk">
                                        <a href="javascript:;" onclick="buyPlan({{@$plan->id}});">{{ $key==0?
                                            "Renew":"Comming Soon" }}</a>
                                        {{-- <a href="javascript:;" onclick="buyPlan({{@$plan->id}});">{{ $key==0?
                                            "Renew":"Comming Soon" }}</a> --}}
                                    </div>
                                    @else
                                    <div class="btn_blk">
                                        <a href="javascript:;">{{ $key==0?
                                            "Selected":"Comming Soon" }}</a>
                                        {{-- <a href="javascript:;">{{ $key==0?
                                            "Selected":"Comming Soon" }}</a> --}}
                                    </div>
                                    @endif

                                    @else
                                    <div class="btn_blk">
                                        {{-- <a href="javascript:;">{{ $key==0?
                                            "Buy Plan":"Comming Soon" }} </a> --}}
                                        {{-- <a href="javascript:;" @if($key == 0) onclick="buyPlan({{@$plan->id}});" @endif>{{ $key==0 ? "Buy Plan" : "Coming Soon" }}</a> --}}
                                        {{-- is_trial == false then show free trail it--}}
                                        @if($is_trial == false && $key==0)
                                        {{-- text Free Trial --}}
                                        <a href="{{ route('guest.trail.payment.form', ['plan_id' => @$plan->id]) }}">Free Trial</a>
                                        @else
                                        <a href="javascript:;" @if($key == 0) onclick="buyPlan({{@$plan->id}});" @endif>{{ $key==0 ? "Buy Plan" : "Coming Soon" }}</a>
                                        @endif

                                        {{-- <a href="javascript:;" onclick="buyPlan({{@$plan->id}});">{{ $key==0?
                                            "Buy Plan":"Comming Soon" }} </a> --}}
                                    </div>
                                    @endif

                                </div>
                                <div class="off">
                                    <!-- 50% off if price is under £1000 -->
                                </div>
                                <div class="price_blk">
                                    <div class="price">£{{$plan->monthly_price != null ? $plan->monthly_price : '0.00'}}
                                    </div>
                                    <span>30 Days</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div>

                <!--Form for inserting data--->
                <div class="addPricing_section" style="display:none;">
                    <div class="table_dv">
                        <div class="table_cell">
                            <div class="contain">
                                <div class="_inner">
                                    <button type="button" class="x_btn" onclick="backToList();"></button>
                                    <h4>Buy Plan</h4>
                                    <form action="{{ route('subscribe.process') }}" method="POST" id="payment-form">
                                        @csrf
                                        <div class="form_row row">
                                            <input type="hidden" id="plan_id" name="plan_id" value="">
                                            <div class="col-sm-4">
                                                <h6>Card Number</h6>
                                                <div class="form_blk">
                                                    <div id="card-number-element"
                                                        class="form-control text_box stripe-element"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>Expiration Date</h6>
                                                <div class="form_blk">
                                                    <div id="card-expiry-element"
                                                        class="form-control text_box stripe-element"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>CVC</h6>
                                                <div class="form_blk">
                                                    <div id="card-cvc-element"
                                                        class="form-control text_box stripe-element"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>ZIP Code</h6>
                                                <div class="form_blk">
                                                    <div id="card-zip-element"
                                                        class="form-control text_box stripe-element"></div>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="btn_blk">
                                                    <button type="submit" class="site_btn md auto" id="buyNow_btn">Buy
                                                        Now</button>
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

    </main>

    @include('layouts.master.user_template.footer')

</body>

</html>




<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('assets_customer/customjs/script_subscription.js') }}"></script>

<script>
    $(document).ready(function () {
            @if (Session::has('success'))
                setTimeout(function(){
                    toastr.success("{{ Session::get('success') }}", '', {timeOut: 5000});
                }, 1000);
            @endif
            @if (Session::has('error'))
                setTimeout(function(){
                    toastr.error("{{ Session::get('error') }}", '', {timeOut: 5000});
                }, 1000);
            @endif
        });

        var stripe = Stripe('{{ getStripePk() }}');//env('STRIPE_KEY')
        var elements = stripe.elements();

        // Create individual elements for each field
        var style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var cardNumber = elements.create('cardNumber', { style: style });
        cardNumber.mount('#card-number-element');

        var cardExpiry = elements.create('cardExpiry', { style: style });
        cardExpiry.mount('#card-expiry-element');

        var cardCvc = elements.create('cardCvc', { style: style });
        cardCvc.mount('#card-cvc-element');

        var cardZip = elements.create('postalCode', { style: style });
        cardZip.mount('#card-zip-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    // Display error.message in your UI.
                    toastr.error(result.error.message, '', {
                        timeOut: 3000
                    });
                } else {
                    $("#buyNow_btn").prop('disabled', true);
                    $('#uiBlocker').show();
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
</script>
