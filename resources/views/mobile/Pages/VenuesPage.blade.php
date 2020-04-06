@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')

@endsection
@section('content')
    <section class="my-3">
        <div class="container">
            <div class="row text_black" >

                <div class="col-12 pl-4" style="font-size: 17px">
                    <div class="row">

                        <h2>{{$current->venue_name}}</h2>
                    </div>
                    <div class="row">
                        <div class="owl-carousel owl-theme" >
                            @foreach($current->images as $key =>$img)
                                <img class="details-image img-responsive" alt="{{$current->venue_name}}" src="{{asset('user_content/'.$img)}}">

                            @endforeach
                        </div>
                    </div>
                    <div class="row ">
                        <div class="it-detail">
                            {!! Markdown::parse($current->description) !!}
                        </div>

                    </div>
                    <div class="row mt-5">
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
            var uluru = {lat: {{$venue->address['latlng']['lat']}}, lng: {{$venue->address['latlng']['lng']}}};
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
