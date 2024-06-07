<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forget Password</title>
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}"/>

    <script>
        var base_url = '{{url('/')}}';
    </script>
</head>

<body data-page="logon">
<div id="uiBlocker" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <img src="{{ asset('assets/images/loading-spinner.gif') }}" alt="Loading..." style="height:150px; width:150px;"/>
        </div>
    </div>
   
	<main>
<section id="logon">
            <div class="side" style="background-image: url('assets/images/cx_mires2-hpbanner_1122x850.jpg');">
                <div class="content text-center">
                    <div class="logo">
                    <a href="index.php" style="background-image: url('<?= asset('assets/images/logo-light.png') ?>'), url('<?= asset('assets/images/logo.png') ?>');"></a>

                    </div>
                    <h1>Reset your password to continue</h1>
                    <p>A platform with efficient integration of many features and so much more</p>
                </div>
            </div>
            <div class="contain">
                <div class="flex_row">
                    <div class="col">
                        <div class="in_col">
                            <form action="" method="POST" id="forgotpasswordform">
                                <div class="log_blk">
                                    <div class="txt text-center">
                                        <h2>Forgot Password</h2>
                                        <p>Don’t worry. Just enter the email address you registered with and we’ll email you instructions to reset your password.</p>
                                    </div>
                                    <div class="form_row row">
                                        <div class="col-xs-12" id="email_div">
                                            <h6>Email Address<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="email" id="email" class="text_box" placeholder="eg: sample@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 hidden" id="otp_div">
                                            <h6>Please enter the otp we sent to you email<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="otp" id="otp" class="text_box" placeholder="- - - - -">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 hidden" id="password_div">
                                            <h6>Enter Your New Password<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="password" id="password" class="text_box">
                                            </div>
                                            <h6>Confirm Password<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="text" name="password_confirmation" id="password_confirmation" class="text_box">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn_blk form_btn">
                                        <button type="button" id="get_otp_btn" class="site_btn block get_otp_btn">Get OTP</button>
                                        <button type="button" id="verify_otp_btn" class="hidden site_btn block verify_otp_btn">Verify OTP</button>
                                        <button type="button" id="reset_password_btn" class="hidden site_btn block reset_password_btn">Reset Password</button>
                                    </div>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </main>
</body>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets_customer/customjs/customer_forgot_password.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/customjs/common.js') }}"></script>

</html>
