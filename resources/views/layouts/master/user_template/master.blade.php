<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lease Match</title>
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
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    <!-- Favicon -->
    <link type="image/png" rel="icon" href="{{ asset('assets/images/favicon.png') }}">

</head>
<script>
    var base_url = "{{url('/')}}";
</script>

<body data-page="account">
    <div id="uiBlocker" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <img src="{{ asset('assets/images/loading-spinner.gif') }}" alt="Loading..." style="height:150px; width:150px;"/>
        </div>
    </div>

    @include('layouts.master.user_template.header')
    
    <main>
    
        @include('layouts.master.user_template.sidebar')

        @yield('content')
        
    </main>
    
    @include('layouts.master.user_template.footer')

</body>

</html>