 <!-- footer -->
 <footer style="padding-top:0px;">
    <div class="contain-fluid">
        <!-- <div class="top_blk">
            <div class="logo">
                <a href="index.php" style="background-image: url('{{asset('assets/images/logo-light.png')}}');"></a>
            </div>
            <ul class="social_links">
                <li><a href="https://www.facebook.com/" target="_blank"><img src="{{asset('assets/images/social-facebook.svg')}}"></a></li>
                <li><a href="https://twitter.com/" target="_blank"><img src="{{asset('assets/images/social-twitter-new.svg')}}"></a></li>
                <li><a href="https://www.instagram.com/" target="_blank"><img src="{{asset('assets/images/social-instagram.svg')}}"></a></li>
                <li><a href="https://www.youtube.com/" target="_blank"><img src="{{asset('assets/images/social-youtube.svg')}}"></a></li>
            </ul>
        </div> -->
        <div class="copyright relative align-items-center justify-content-center">
            <div class="inner">
            <div class="logo" style="margin-bottom: 0px;">
                <a href="{{route('customer.dashboard')}}" style="background-image: url('{{asset('assets/images/logo-light.png')}}');"></a>
            </div>    
            <!-- <ul class="smLst flex">
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="terms-and-conditions.php">Terms & Conditions</a></li>
                </ul> -->
                <p style="margin-top:15px;">Copyright © 2022 <a href="index.php">Lease Match</a> All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<!-- footer -->


 
<!-- JS Files -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/select.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.rateyo.min.js') }}"></script>
<script src="{{ asset('assets/js/multi-animated-counter.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('assets/customjs/common.js') }}"></script>


@stack('script')