@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('after_styles')
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.theme.default.min.css')}}">
@endsection
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('about',trans('ClientSide.concert_halls'))}}
    <section class="my-3">
        <div class="container">
            <div class="row text_black" >
                <div class="col-3">


                    <ul class="list-group w-100 " style="float: left;height: 100%; background-color: #ffffff; z-index: 10;position: relative;color: #000000;font-size: 17px;">
                        <li class="list-group-item border-0 pl-0">
                            <h3>@lang('ClientSide.concert_halls')</h3><div style="background-color: rgba(211,61,51,1);height: 5px;width: 80px;margin-bottom: 15px;"></div> </li>
                        @foreach($venues as $venue)
                            <li class="list-group-item border-0 pl-0">
                                <a class="text-dark capitalizer" href="{{route('venues',['id'=>$venue->id])}}">{{$venue->venue_name}}</a></li>
                        @endforeach
                    </ul>
                    <div style="width: 5px;float: left;height: calc(100% - 20px); margin-top: 10px; margin-left: -6px; box-shadow: 2px 0 10px rgba(0,0,0,.1)"></div>
                </div>
                <div class="col-9 pl-4" style="font-size: 17px">
                    <div class="row">

                        <h2>{{$current->venue_name}}</h2>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="owl-carousel owl-theme" >
                            @foreach($current->images as $key =>$img)
                                <img class="details-image img-responsive" alt="{{$current->venue_name}}" src="{{asset('user_content/'.$img)}}">

                            @endforeach
                            </div>
                        </div>
                        <div class="col-8 ">
                            <div class="it-detail">
                                {!! Markdown::parse($current->description) !!}
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="google-maps content" id="map" style="height: 250px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('after_scripts')
    <script src="{{asset('vendor/owlcarousel/owl.carousel.min.js')}}"></script>
    <script>
        $(".owl-carousel").owlCarousel({
            loop:true,
            nav:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });

        function initMap() {
            var uluru = {lat: {{$current->address['latlng']['lat']}}, lng: {{$current->address['latlng']['lng']}}};
            var map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 15
            });
            var marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_places.key')}}&callback=initMap"
            async defer></script>
@endsection
