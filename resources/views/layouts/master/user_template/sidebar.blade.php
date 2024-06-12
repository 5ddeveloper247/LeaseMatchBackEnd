<aside>
    <div class="logo_blk">
        <div class="logo">
            <a href="{{route('customer.dashboard')}}" style="background-image: url('{{ asset('assets/images/logo-light.png') }}');"></a>
        </div>
        <button type="button" class="toggle"><span></span></button>
    </div>
    
    <div class="inside">
        <ul>
            <li class="{{$page == 'Dashboard' ? 'active' : ''}}">
                <a href="{{route('customer.dashboard')}}">
                    <img src="{{asset('assets/images/icon-home.svg')}}" alt="">
                    <em>Dashboard</em>
                </a>
            </li>
            <li class="{{$page == 'Matches' ? 'active' : ''}}">
                <a href="{{route('customer.myMatches')}}">
                    <img src="{{asset('assets/images/icon-search.svg')}}" alt="">
                    <em>My Matches</em>
                </a>
            </li>
            <li class="{{$page == 'Subscription' ? 'active' : ''}}">
                <a href="{{route('customer.mySubscription')}}">
                    <img src="{{asset('assets/images/icon-pricing.svg')}}" alt="">
                    <em>My Subscription</em>
                </a>
            </li>
            <li class="{{$page == 'My Account' ? 'active' : ''}}">
                <a href="{{route('customer.account_info')}}">
                    <img src="{{asset('assets/images/icon-pricing.svg')}}" alt="">
                    <em>My Account</em>
                </a>
            </li>
            <li class="{{$page == 'Property Information' ? 'active' : ''}}">
                <a href="{{route('customer.property_info')}}">
                    <img src="{{asset('assets/images/icon-pricing.svg')}}" alt="">
                    <em>Property Information</em>
                </a>
            </li>
            
            <li class="">
                <a href="{{route('customer.logout')}}">
                    <img src="{{asset('assets/images/icon-signout.svg')}}" alt="">
                    <em>Logout</em>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- aside -->