<aside>
    <div class="logo_blk">
        <div class="logo">
            <a href="{{route('customer.dashboard')}}" style="background-image: url('{{ asset('assets/images/logo-light.png') }}');"></a>
        </div>
        <button type="button" class="toggle"><span></span></button>
    </div>
    
    <div class="inside">
        <ul>
            <!-- <li class="{{$page == 'Dashboard' ? 'active' : ''}}">
                <a href="{{route('customer.dashboard')}}">
                    <img src="{{asset('assets/images/icon-home.svg')}}" alt="">
                    <em>Dashboard</em>
                </a>
            </li> -->
            <li class="{{$page == 'Matches' ? 'active' : ''}}">
                <!-- <a href="{{route('customer.myMatches')}}">
                    <img src="{{asset('assets/images/icon-search.svg')}}" alt="">
                    <em>My Matches</em>
                </a> -->

                <a href="{{route('customer.myMatches')}}" data-title="My Matches">
                   <img src="{{asset('assets/images/icon-search.svg')}}" alt="">
                   <em>My Matches</em>
                </a>

            </li>
            <li class="{{$page == 'Subscription' ? 'active' : ''}}">
                <a href="{{route('customer.mySubscription')}}" data-title="My Subscription">
                    <img src="{{asset('assets/images/icon-pricing.svg')}}" alt="">
                    <em>My Subscription</em>
                </a>
            </li>
            <li class="{{$page == 'My Account' ? 'active' : ''}}">
                <a href="{{route('customer.account_info')}}" data-title="My Account">
                    <img src="{{asset('assets/images/icon-user.svg')}}" alt="">
                    <em>My Account</em>
                </a>
            </li>
            <li class="{{$page == 'Property Information' ? 'active' : ''}}">
                <a href="{{route('customer.property_info')}}" data-title="Property Information">
                    <img src="{{asset('assets/images/icon-list.svg')}}" alt="">
                    <em>Property Information</em>
                </a>
            </li>
            
            <li class="">
                <a href="{{route('customer.logout')}}" data-title="Logout">
                    <img src="{{asset('assets/images/icon-signout.svg')}}" alt="">
                    <em>Logout</em>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- aside -->

<style scoped>

@media (max-width: 768px) {
    aside ul li a {
    position: relative;
}

aside ul li a::before {
    content: attr(data-title);
    position: absolute;
    bottom: 60%; 
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px 8px;
    border-radius: 4px;
    opacity: 0;
    transition: opacity 0.3s ease;
    white-space: nowrap;
    pointer-events: none;
    font-size: 0.9rem;
}

aside ul li a:hover::before {
    opacity: 1;
}
}

    </style>