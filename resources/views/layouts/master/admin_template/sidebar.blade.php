<aside>
    <div class="logo_blk">
        <div class="logo">
            <a href="{{route('admin.dashboard')}}" style="background-image: url('{{ asset('assets/images/logo-light.png') }}');"></a>
        </div>
        <button type="button" class="toggle"><span></span></button>
    </div>
    <!-- <div class="mini_btn">
        <a href="javascript:;"><img src="{{asset('assets/images/symbol-comments.svg')}}" alt="">Live Chat</a>
        <a href="javascript:;"><img src="{{asset('assets/images/symbol-envelope.svg')}}" alt="">Email</a>
        <a href="javascript:;"><img src="{{asset('assets/images/symbol-headphone.svg')}}" alt="">Phone</a>
    </div> -->
    <div class="inside">
        <ul>
            <?php 
                $menu = getLeftMenu();
            ?>
            @if(count($menu) > 0)
                @foreach($menu as $value)
                    <li class="{{$page == $value->name ? 'active' : ''}}">
                        <a href="{{route($value->route)}}">
                            <img src="{{asset($value->image)}}" alt="">
                            <em>{{$value->name}}</em>
                        </a>
                    </li>
                @endforeach
            @endif
            
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