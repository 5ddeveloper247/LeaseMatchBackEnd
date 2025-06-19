<?php use Carbon\Carbon; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lease Match</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">

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
    var base_url = "{{ url('/') }}";
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


                <!--Form for inserting data--->
                <div class="container my-5">
                    <div class="row g-4"
                        style="background-color: #fff; border-radius: 8px; padding: 4rem; display: flex; align-items: center !important">
                        <div class="col-lg-5">
                            <div class="border rounded p-5 shadow-sm bg-light"
                                style="border-radius: 20px; background: linear-gradient(145deg, #ffffff 0%, #f1f5f9 100%); border: 1px solid rgba(226, 232, 240, 0.8); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.6); position: relative; overflow: hidden;">
                                <img src="https://img.freepik.com/free-vector/innovation-concept-illustration_114360-5848.jpg?ga=GA1.1.1410736458.1721019759&semt=ais_hybrid&w=740"
                                    style="width: 200px" alt="">


                                <h4 style="margin-bottom: 2rem; font-weight: 700">Payment Summary</h4>
                                <ul class="list-unstyled">
                                    <li style="margin-bottom: .6rem"><strong>Plan:</strong>
                                        {{ $data['plan_detail']->title ?? 'N/A' }}</li>
                                    <li style="margin-bottom: .6rem"><strong>Price:</strong>
                                        £{{ $data['plan_detail']->monthly_price ?? '0.00' }} / month</li>
                                    <li style="margin-bottom: .6rem"><strong>Features:</strong></li>
                                    <ul class="mb-0">
                                        <li>✔️ Number of matches: {{ $data['plan_detail']->number_of_matches }}</li>
                                        <li>✔️ 24/7 Support</li>
                                        <li>✔️ Priority Features</li>
                                    </ul>
                                </ul>
                                <hr>
                                <p class="text-muted small mb-0">Your card will be charged after your 30-day free trial
                                    ends.</p>
                            </div>
                        </div>

                        <div class="col-lg-7"
                            style="background-image: url('https://img.freepik.com/free-vector/wallet-concept-illustration_114360-2805.jpg?ga=GA1.1.1410736458.1721019759&semt=ais_hybrid&w=740'); background-position: center; background-size: cover; padding: 3rem; ">
                            <div class="addPricing_section"
                                style="background-color: #ffffffb0; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">


                                <div class="table_dv">
                                    <div class="table_cell">
                                        <div class="contain">
                                            <div class="_inner">
                                                @if (isset($plan_id) && $plan_id != null)
                                                    <a href="{{ route('guest.guestSubscriptions') }}" class="x_btn"
                                                        style="top: -2rem !important; right: -4rem !important; background: rgba(255,255,255,0.9); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; border: none; color: #64748b; font-size: 1.2rem;"
                                                        onmouseover="this.style.background='#051855'; this.style.color='#ef4444'; this.style.transform='rotate(90deg)'"
                                                        onmouseout="this.style.background='rgba(255,255,255,0.9)'; this.style.color='#64748b'; this.style.transform='rotate(0deg)'"></a>
                                                @else
                                                    <button type="button" class="x_btn" onclick="backToList();"
                                                        style="background: rgba(255,255,255,0.9); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; border: none; color: #64748b; font-size: 1.2rem;"
                                                        onmouseover="this.style.background='#051855'; this.style.color='#ef4444'; this.style.transform='rotate(90deg)'"
                                                        onmouseout="this.style.background='rgba(255,255,255,0.9)'; this.style.color='#64748b'; this.style.transform='rotate(0deg)'"></button>
                                                @endif



                                                <!-- Payment form -->
                                                <form id="payment-form" method="POST"
                                                    action="{{ route('guest.stripe.payment_card.store') }}">
                                                    @csrf

                                                    <!-- Stripe will inject the card UI here -->
                                                    <div id="card-element"></div>

                                                    <!-- Display card errors here -->
                                                    <div id="card-errors" role="alert" style="color: red;"></div>

                                                    <button type="submit"
                                                        style="margin-top: 1.5rem;
                                                        background: #051855;
                                                        color: #fff;
                                                        border: 1px solid #051855;
                                                        border-radius: 5px;
                                                        padding: 3px 6px;
                                                        font-size: 14px;
                                                        font-weight: 500;
                                                        cursor: pointer;
                                                        transition: all 0.3s ease-in-out;"
                                                        onmouseover=" this.style.color='#05d9e8'; this.style.borderColor='#122c84';"
                                                        onmouseout="this.style.background='#051855'; this.style.color='#fff'; this.style.borderColor='#051855';">Submit
                                                        Payment</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /.addPricing_section -->
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
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    const card = elements.create("card");
    card.mount("#card-element");

    card.on("change", function(event) {
        const displayError = document.getElementById("card-errors");
        displayError.textContent = event.error ? event.error.message : "";
    });

    const form = document.getElementById("payment-form");
    const clientSecret = "{{ $clientSecret }}";

    form.addEventListener("submit", async function(event) {
        event.preventDefault();

        const {
            error,
            setupIntent
        } = await stripe.confirmCardSetup(clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: "{{ auth()->user()->name ?? '' }}",
                    email: "{{ auth()->user()->email ?? '' }}"
                }
            }
        });

        if (error) {
            let errorMessage = error.message;

            // Stripe returns a generic message in this specific case
            if (error.code === 'setup_intent_unexpected_state') {
                errorMessage = "You cannot confirm this SetupIntent because it has already succeeded.";
            }

            document.getElementById("card-errors").textContent = errorMessage;
            toastr.error(`❌ ${errorMessage}`);
            console.error("Stripe error:", error);
        } else {
            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({
                        payment_method: setupIntent.payment_method
                        // plan_id: selectedPlanId
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    toastr.info("🎉 Card details saved successfully for future use.");
                    toastr.info("✅ You've been subscribed to a free 30-day trial.");
                    setTimeout(() => {
                        toastr.warning("Redirecting....");
                    }, 3000);
                    setTimeout(() => {
                        window.location.href = "/customer/mySubscription";
                    }, 6000);
                } else {
                    toastr.error(
                        `❌ ${result?.error?.message || "Failed to save card details. Please try again."}`
                    );
                    toastr.error("ℹ️ Please contact support if the issue persists.");
                    // console.error("Error storing payment method:", result);
                }
            } catch (e) {
                toastr.error("⚠️ Unexpected error while saving card details.");
                // console.error("Exception:", e);
            }
        }
    });
</script>


{{-- <script>
    document.getElementById("payment-form").onsubmit = function(event) {
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
    document.getElementById("card-expiry").addEventListener("input", function(event) {
        let input = event.target.value.replace(/\D/g, ""); // Remove non-numeric characters
        if (input.length > 2) {
            input = input.slice(0, 2) + "/" + input.slice(2);
        }
        event.target.value = input;
    });
</script> --}}

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
