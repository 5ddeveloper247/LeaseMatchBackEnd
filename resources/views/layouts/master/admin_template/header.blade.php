@php
use Carbon\Carbon;
@endphp
<header>
    <div class="contain-fluid">
        <div id="nav">
            <nav class="ease"></nav>

            <div class="d-flex align-items-center gap-4 justify-content-end text-end" style="width:100%">
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
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z" />
                            </svg> -->
                        </div>
                        <hr>
                        <div class="Notifications-dropdown">
                            <div id="All" class="tab-pane fade in active">
                                <div class="d-flex align-items-center justify-content-between see-all-div">
                                    @if($notifCount > 0)
                                    <h5>Earlier</h5>
                                    <a class="pointer read_all_notif_admin">Read All</a>
                                    @endif
                                </div>
                                <div class="content-scrollbar">
                                    <?php
                                        $notifications = getAllUnReadNotifs();
                                    ?>
                                    @if(count($notifications) > 0)
                                    @foreach($notifications as $key => $value)
                                    @php
                                    $class = '';
                                    switch ($key % 3) {
                                    case 0:
                                    $class = 'custom-name-success'; break;
                                    case 1:
                                    $class = 'custom-name-info'; break;
                                    case 2:
                                    $class = 'custom-name-danger'; break;
                                    }
                                    @endphp

                                    <div class="d-flex align-items-center Notifications-sub-dropdown-main">
                                        <div class="custom-name me-2 {{ @$class }}">
                                            {{ strtoupper(substr(@$value->fromUser->first_name, 0, 2)) }}
                                        </div>
                                        <p>
                                            <span class="bold">{{ @$value->fromUser->first_name }}</span>
                                            {{ @$value->subject }}<br>
                                            <span class="coloured-small-text">{{
                                                Carbon::parse(@$value->created_at)->format('d M Y - h:i A') }}</span>
                                        </p>

                                        @if($value->read_flag ==0)
                                        <button class="btn btn-sm btn-primary mark-as-read" data-id="{{ $value->id }}">
                                            Mark as Read
                                        </button>
                                        @endif
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
                            @if (Auth::user()->profile_picture !==null)
                            <img src="{{url('/').'/public'.Auth::user()->profile_picture}}" alt="">
                            @else
                            <img src="{{asset('assets/images/users/5.jpg')}}" alt="">
                            @endif
                        </div>
                        <div class="name" title="{{Auth::user()->first_name}}">{{trimText(Auth::user()->first_name,
                            10)}} <small>Admin</small></div>
                    </div>
                    <div class="drop_cnt">
                        <ul class="drop_lst">
                            <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                            <li><a href="{{route('admin.logout')}}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', function () {
            const notificationId = this.dataset.id;


            fetch(`/admin/notifications/mark-as-read/${notificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ id: notificationId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.remove(); // Remove the button after marking as read
                    toastr.success(data.message,'Success!',{
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-center',
                        timeOut: 5000,
                        extendedTimeOut: 3000,
                    });
                } else {
                   toastr.error(data.message,'Error',{
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-center',
                    timeOut: 5000,
                    extendedTimeOut: 3000,
                   })
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>
<!-- header -->
