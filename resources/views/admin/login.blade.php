<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Lease Match</title>
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Css Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<style>
    @media (max-width: 500px) {

        .side,
        .content {
            height: 16vh !important;
            background-color: #051855 !important;
        }

        .margin {
            margin: 0 -4rem !important;
        }
    }

    @media (max-width: 576px) {
        #logon .forgot {
            margin-top: 1px;
            font-size: 11px;
        }

        .lbl_btn label {
            font-size: 12px;
        }
    }
</style>

<body data-page="logon">

    <main>
        <section id="logon">
            <div class="side"
                style="background-image: url('{{ asset('assets/images/Number-of-Vetted-Renters.jpg') }}');">
                <div class="content text-center">
                    <div class="logo">
                        <a href="index.php"
                            style="background-image: url('{{ asset('assets/images/logo-light.png') }}'),  url('{{ asset('assets/images/logo-light.png') }}');"></a>
                    </div>
                    <h1>Please Login to continue</h1>
                    <p>A platform with efficient integration of many features and so much more</p>
                </div>
            </div>
            <div class="contain mx-5 px-5 mx-lg-0 px-lg-0">
                <div class="flex_row">
                    <div class="col">
                        <div class="in_col">

                            <form class="mx-5 px-5 mx-lg-0 px-lg-0 margin" action="{{route('admin.loginSubmit')}}"
                                method="POST">
                                @csrf
                                <div class="log_blk">
                                    <div class="txt text-center">
                                        <h2>Sign In</h2>
                                        <!-- <p>Don’t have an account? <a href="register.php">Register</a></p> -->
                                    </div>
                                    @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                    @elseif($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="form_row row">
                                        <div class="col-xs-12">
                                            <h6>Email Address<sup>*</sup></h6>
                                            <div class="form_blk">
                                                <input type="email" name="email" id="email" class="text_box"
                                                    placeholder="eg: sample@gmail.com">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <h6>Password<sup>*</sup></h6>
                                            <div class="form_blk pass_blk">
                                                <input type="password" name="password" id="password"
                                                    class="text_box password-input" placeholder="eg: PassLogin%7"
                                                    autocomplete="new-password">
                                                <i class="icon-eye toggle-password" id="eye"></i>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <div class="lbl_btn">
                                                    <input type="checkbox" name="remember" id="remember">
                                                    <label for="remember">Remember me</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="btn_blk form_btn">
                                            <button type="submit" class="site_btn block">Login</button>
                                        </div>
                                        <div class="btn_blk form_btn">
                                            <button type="button" class="site_btn block"><a class="site_btn block"
                                                    href="https://www.leasematch.nyc/" style="text-decoration: none">Go
                                                    To Website</a></button>
                                        </div>
                                    </div>
                                    <!-- <div class="forgot text-center">
                                        <a href="forgot-password.php" id="pass">Forgot Password?</a>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- logon -->
    </main>
</body>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

</html>
