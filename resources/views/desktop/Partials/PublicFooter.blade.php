<!-- Footer -->
<footer class="g-bg-main-light-v1">
    <!-- Content -->
    <div class="g-brd-bottom g-brd-secondary-light-v1 pb-5" style="border-bottom: none !important">
        <div class="container g-pt-100">
            <div class="row justify-content-start g-mb-30 g-mb-0--md">
                <div class="col-12 footer-header mb-5" style="padding: 0 20%;">
                    <h2>{{__('ClientSide.want')}}</h2>
                    <form action="{{route('subscription')}}" method="POST" class="row ajax">
                        @csrf
                        <div class="col-9 form-group">
                            <input type="email" class="form-control" name='email' placeholder="{{__("ClientSide.email")}}">
                        </div>
                        <div class="col-3 form-group">
                            <input type="submit" class="form-control four-button-type" value="{{__("ClientSide.subscribe")}}">
                        </div>
                    </form>
                    <h6>{{__("ClientSide.email_for")}}</h6>
                </div>
                <div class="col-3">
                    <a href="" style="width: 100%">
                        <img src="{{asset('assets/images/logo/bilet-logo.svg')}}" class="footer-logo">
                    </a>
                    <ul class="list-inline mb-50 row footer-social-icons pt-4" style="width: 100%">
                        <li class="text-center">
                            <a href="{{\Backpack\Settings\app\Models\Setting::get('social_facebook')}}">
                                <img src="{{asset('assets/images/icons/social/3.svg')}}"></a>
                        </li>
                        <li class="text-center">
                            <a href="{{\Backpack\Settings\app\Models\Setting::get('social_pinterest')}}">
                                <img src="{{asset('assets/images/icons/social/2.svg')}}"></a>
                        </li>
                        <li class="text-center">
                            <a href="{{\Backpack\Settings\app\Models\Setting::get('social_twitter')}}">
                                <img src="{{asset('assets/images/icons/social/1.svg')}}"></a>
                        </li>
                        <li class="text-center">
                            <a href="{{\Backpack\Settings\app\Models\Setting::get('social_linkedin')}}"
                            ><img src="{{asset('assets/images/icons/social/4.svg')}}"></a>
                        </li>
                    </ul>
                </div>
                <div class="col-3 col-3-with-text">
                    <ul>
                        <li><a href="#">{{__('ClientSide.introduction')}}</a></li>
                        <li><a href="#">{{__("ClientSide.questions")}}</a></li>
                        <li><a href="#">{{__("ClientSide.offices")}}</a></li>
                        <li><a href="#">{{__("ClientSide.rassylka")}}</a></li>
                    </ul>
                </div>
                <div class="col-3 col-3-with-text">
                    <ul>

                        <li><a href="#">{{__("ClientSide.collective")}}</a></li>
                        <li><a href="#">{{__("ClientSide.organizers")}}</a></li>
                        <li><a href="#">{{__("ClientSide.concert_halls")}}</a></li>
                    </ul>
                </div>
                <div class="col-3 col-3-with-text">
                    <ul>
                        <li><a href="#">{{__("ClientSide.partners")}}</a></li>
                        <li><a href="#">{{__("ClientSide.logo")}}</a></li>
                        <li><a style="color: #ffffff; cursor: pointer" data-toggle="modal" data-target="#exampleModalCenter">{{__("ClientSide.addEvent")}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    <!-- Copyright -->
    <div class="container g-pt-30 g-pb-10 pt-4">
        <div class="row justify-content-between align-items-center" style="border-top: 1px solid #ffffff">
            <div class="col-12">
                <p class="g-font-size-13 mb-0 text-center all-rights-reserved">&copy; 2020 {{__("ClientSide.ticket_service")}} Billettm.com. {{__("ClientSide.copyright")}}.</p>
            </div>
        </div>
    </div>
    <!-- End Copyright -->
</footer>
<!-- End Footer -->
