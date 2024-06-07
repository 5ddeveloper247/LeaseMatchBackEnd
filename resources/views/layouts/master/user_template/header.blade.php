<header>
    <div class="contain-fluid">
        <div id="nav">
            <nav class="ease"></nav>
           
          
            <div id="pro_btn" class="drop_down">
                <div class="drop_btn">
                    <div class="ico">
                        <img src="{{asset('assets/images/users/5.jpg')}}" alt="">
                    </div>
                    <div class="name text-capitalize">{{Auth::user()->first_name}} <small>Customer</small></div>
                </div>
                <div class="drop_cnt">
                    <ul class="drop_lst">
                       
                        <li><a href="{{route('customer.logout')}}">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header -->