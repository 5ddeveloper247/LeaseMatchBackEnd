@php
use Carbon\Carbon;
@endphp
<header>
    <div class="contain-fluid">
        <div id="nav">
            <nav class="ease"></nav>
           
            <ul id="icon_btn" class="drop_down">
                <div class="drop_btn">
                    <li id="noti">
                        <a href="#">
                            <img src="{{asset('assets/images/icon-bell.svg')}}" alt="">
                            <?php 
                                $notifCount = getNotifCount();
                            ?>
                            @if($notifCount>0)
                                <span class="notif-icon" style="left: 25px;top: -5px;"></span>
                            @endif
                        </a>
                    </li>
                </div>
                <div class="drop_cnt drop-down-content">
                    <div class="d-flex-notifications">
                        <h4 class="p-5 padding-md">Notifications</h4>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z" />
                        </svg>
                    </div>
                    <hr>
                    <div class="Notifications-dropdown">
                        <div id="All" class="tab-pane fade in active">
                            <div class="d-flex align-items-center justify-content-between see-all-div">
                                @if($notifCount>0)
                                    <h5>Earlier</h5>
                                    <a class="pointer read_all_notif_user">Read All</a>
                                @endif
                            </div>
                            <div class="content-scrollbar">
                                <?php 
                                    $notifications = getAllUnReadNotifs();
                                ?>
                                @if(count($notifications) > 0)
                                @foreach($notifications as $key=>$value)
                                @php
                                    $class = '';
                                    switch ($key % 3) {
                                        case 0:
                                            $class = 'custom-name-success';break;
                                        case 1:
                                            $class = 'custom-name-info';break;
                                        case 2:
                                            $class = 'custom-name-danger';break;
                                    }
                                @endphp
                                <div class="d-flex align-items-center Notifications-sub-dropdown-main">
                                    <!-- <img src="{{asset('assets/images/users/5.jpg')}}" alt=""> -->
                                    <div class="custom-name me-2 {{@$class}}">
                                        {{ strtoupper(substr(@$value->fromUser->first_name, 0, 2)) }}
                                    </div>
                                    <p><span class="bold">{{@$value->fromUser->first_name}}</span> {{@$value->subject}}<br>
                                        <span class="coloured-small-text">{{ Carbon::parse(@$value->created_at)->format('d M Y - h:i A') }}</span>
                                    </p>
                                </div>
                                @endforeach
                                @else
                                <div class="text-center">No new notifications...</div>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </ul>

            <div id="pro_btn" class="drop_down">
                <div class="drop_btn">
                    <div class="ico">
                        <img src="{{asset('assets/images/users/5.jpg')}}" alt="">
                    </div>
                    <div class="name text-capitalize" title="{{Auth::user()->first_name}}">{{trimText(Auth::user()->first_name, 10)}} <small>Customer</small></div>
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