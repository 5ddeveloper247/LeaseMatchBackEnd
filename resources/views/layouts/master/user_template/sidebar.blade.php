<aside>
    <div class="logo_blk">
        <div class="logo">
            <a href="{{route('customer.dashboard')}}" style="background-image: url('{{ asset('assets/images/logo-light.png') }}');"></a>
        </div>
        <button type="button" class="toggle"><span></span></button>
    </div>
    
    <div class="inside">
        <ul>
        <li class="active">
                        <a href="{{route('customer.dashboard')}}">
                            <img src="{{asset('assets/images/icon-home.svg')}}" alt="">
                            <em>Dashboard</em>
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