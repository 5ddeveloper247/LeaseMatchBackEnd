<aside>
    <div class="logo_blk">
        <div class="logo">
            <a href="{{route('admin.dashboard')}}" style="background-image: url('{{ asset('assets/images/logo-light.png') }}');"></a>
        </div>
        <button type="button" class="toggle"><span></span></button>
    </div>
    <div class="mini_btn">
        <!-- <a href="?"><img src="{{asset('assets/images/symbol-comments.svg')}}" alt="">Live Chat</a> -->
        <a href="?"><img src="{{asset('assets/images/symbol-envelope.svg')}}" alt="">Email</a>
        <a href="?"><img src="{{asset('assets/images/symbol-headphone.svg')}}" alt="">Phone</a>
    </div>
    <div class="inside">
        <ul>
            <li class="{{$page == 'Dashboard' ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}">
                    <img src="{{asset('assets/images/icon-home.svg')}}" alt="">
                    <em>Dashboard</em>
                </a>
            </li>
            <li class="{{$page == 'Subscription' ? 'active' : ''}}">
                <a href="{{route('admin.subscription')}}">
                    <img src="{{asset('assets/images/icon-pricing.svg')}}" alt="">
                    <em>Subscriptions</em>
                </a>
            </li>
            
            <li class="">
                <a href="{{route('admin.logout')}}">
                    <img src="{{asset('assets/images/icon-signout.svg')}}" alt="">
                    <em>Logout</em>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- aside -->