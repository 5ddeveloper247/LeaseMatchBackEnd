<header>
    <div class="contain-fluid">
        <div id="nav">
            <nav class="ease"></nav>
           
            <ul id="icon_btn">
                <li id="noti">
                    <a href="javascript:;">
                        <img src="{{asset('assets/images/icon-bell.svg')}}" alt="">
                    </a>
                </li>
            </ul>
            <div id="pro_btn" class="drop_down">
                <div class="drop_btn">
                    <div class="ico">
                        <img src="{{asset('assets/images/users/5.jpg')}}" alt="">
                    </div>
                    <div class="name">John Wick <small>Trader</small></div>
                </div>
                <div class="drop_cnt">
                    <ul class="drop_lst">
                        <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li><a href="login.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header -->