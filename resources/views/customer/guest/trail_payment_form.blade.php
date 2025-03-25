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
                {{-- <div id="slick-pricing" class="slick-carousel pricingList_section">
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
                                        <a href="javascript:;" onclick="buyPlan({{@$plan->id}});">Renew</a>
                                    </div>
                                    @else
                                    <div class="btn_blk">
                                        <a href="javascript:;">Selected</a>
                                    </div>
                                    @endif

                                    @else
                                    <div class="btn_blk">
                                        <a href="javascript:;" onclick="buyPlan({{@$plan->id}});">Buy Plan</a>
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

                </div> --}}

                <!--Form for inserting data--->
                <div class="addPricing_section">
                    <div class="table_dv">
                        <div class="table_cell">
                            <div class="contain">
                                <div class="_inner">
                                    {{-- check isset $plan_id --}}
                                    @if(isset($plan_id) && $plan_id != null)
                                    <a href="{{ route('guest.guestSubscriptions') }}" class="x_btn"></a>
                                    @else
                                    <button type="button" class="x_btn" onclick="backToList();"></button>
                                    @endif

                                    <form action="{{ route('guest.trail.card.process') }}" method="POST" id="payment-form">
                                        @csrf
                                        <div class="form_row row">
                                            @if(isset($plan_id) && $plan_id != null)
                                            <input type="hidden" id="plan_id" name="plan_id" value="{{ $plan_id }}">
                                            @else
                                            <input type="hidden" id="plan_id" name="plan_id" value="">
                                            @endif

                                            <div class="col-sm-4">
                                                <h6>Card Number</h6>
                                                <div class="form_blk">
                                                    <input type="text" id="card-number" name="card_number"
                                                        class="form-control text_box" placeholder="1234 5678 9012 3456"
                                                        required maxlength="19" onkeyup="validateCardNumber()">
                                                    <small id="card-number-error" class="error-message"></small>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>Expiration Date</h6>
                                                <div class="form_blk">
                                                    <input type="text" id="card-expiry" name="card_expiry"
                                                        class="form-control text_box" placeholder="MM/YY" required
                                                        maxlength="5" onkeyup="validateExpiry()">
                                                    <small id="card-expiry-error" class="error-message"></small>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>CVC</h6>
                                                <div class="form_blk">
                                                    <input type="text" id="card-cvc" name="card_cvc"
                                                        class="form-control text_box" placeholder="123" required
                                                        minlength="3" maxlength="4" onkeyup="validateCVC()">
                                                    <small id="card-cvc-error" class="error-message"></small>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <h6>ZIP Code</h6>
                                                <div class="form_blk">
                                                    <input type="text" id="card-zip" name="card_zip"
                                                        class="form-control text_box" placeholder="10001" required
                                                        maxlength="6" onkeyup="validateZip()">
                                                    <small id="card-zip-error" class="error-message"></small>
                                                </div>
                                            </div>

                                            <div class="col-sm-2"></div>

                                            <div class="col-sm-2">
                                                <div class="btn_blk">
                                                    <button type="submit" class="site_btn md auto"
                                                        id="submitNow_btn">Save Info</button>
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





<script src="{{ asset('assets_customer/customjs/script_subscription.js') }}"></script>
<script>
    document.getElementById("payment-form").onsubmit = function (event) {
        if (!validateCardNumber() || !validateExpiry() || !validateCVC() || !validateZip()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    };

    function validateCardNumber() {
        let cardNumberField = document.getElementById("card-number");
        let cardNumberError = document.getElementById("card-number-error");
        let cardNumber = cardNumberField.value.replace(/\s+/g, '');

        if (!/^\d{16}$/.test(cardNumber)) {
            cardNumberError.innerText = "Card number must be exactly 16 digits.";
            cardNumberField.style.border = "1px solid red";
            return false;
        }
        cardNumberError.innerText = "";
        cardNumberField.style.border = "";
        return true;
    }

    function validateExpiry() {
        let expiryField = document.getElementById("card-expiry");
        let expiryError = document.getElementById("card-expiry-error");
        let expiry = expiryField.value;

        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
            expiryError.innerText = "Use MM/YY format.";
            expiryField.style.border = "1px solid red";
            return false;
        }

        // Extract MM and YY
        let [month, year] = expiry.split("/").map(num => parseInt(num, 10));
        let currentYear = new Date().getFullYear() % 100; // Get last two digits of current year
        let currentMonth = new Date().getMonth() + 1; // Get current month (1-12)

        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            expiryError.innerText = "Card expiry date must be in the future.";
            expiryField.style.border = "1px solid red";
            return false;
        }

        expiryError.innerText = "";
        expiryField.style.border = "";
        return true;
    }

    function validateCVC() {
        let cvcField = document.getElementById("card-cvc");
        let cvcError = document.getElementById("card-cvc-error");
        let cvc = cvcField.value;

        if (!/^\d{3,4}$/.test(cvc)) {
            cvcError.innerText = "CVC must be 3 or 4 digits.";
            cvcField.style.border = "1px solid red";
            return false;
        }
        cvcError.innerText = "";
        cvcField.style.border = "";
        return true;
    }

    function validateZip() {
        let zipField = document.getElementById("card-zip");
        let zipError = document.getElementById("card-zip-error");
        let zip = zipField.value;

        if (!/^\d{5,6}$/.test(zip)) {
            zipError.innerText = "ZIP Code must be 5 or 6 digits.";
            zipField.style.border = "1px solid red";
            return false;
        }
        zipError.innerText = "";
        zipField.style.border = "";
        return true;
    }

    // Auto-add `/` after MM input
    document.getElementById("card-expiry").addEventListener("input", function (event) {
        let input = event.target.value.replace(/\D/g, ""); // Remove non-numeric characters
        if (input.length > 2) {
            input = input.slice(0, 2) + "/" + input.slice(2);
        }
        event.target.value = input;
    });

</script>

<style>
    .error-message {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>


<style>
    .error-message {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
</style>
