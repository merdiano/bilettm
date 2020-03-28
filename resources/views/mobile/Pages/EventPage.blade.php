@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')
    <link rel="canonical" href="{{$event->event_url}}" />
    <meta property="og:title" content="{{{$event->title}}}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{$event->event_url}}?utm_source=fb" />
    @if($event->images->count())
        <meta property="og:image" content="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" />
    @endif
    <meta property="og:description" content="{{Str::words(strip_tags(Markdown::parse($event->description))), 20}}" />
    <meta property="og:site_name" content="Billetm.com" />
@endsection
@section('content')
    <section class="movie-items-group firts-child">
        <div class="container">
            <div class="row kinoteator tab-part">
                <div class="tab-header d-flex justify-content-between col-12">
                    <h2 style="font-size: 20px; font-weight: bold">«{{$event->title}}»
                        <div class="title-bottom-line"></div>
                    </h2>
                </div>
            </div>
        </div>
    </section>
    <section style="margin-top: 30px; margin-bottom: 50px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <img src="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" style="width: 40%; float: left; margin: 0 15px 10px 0" alt="{{$event->title}}">
                    <p style="color: #000000; font-size: 13px; margin-bottom: 5px;"><b>@lang('ClientSide.description'): </b>{!! Markdown::parse($event->description) !!}</p>
                    <p style="color: #000000; font-size: 13px; margin-bottom: 5px;"><b><i class="fa fa-map-marker"></i> </b><a href="{{route('venues',['id'=> $event->venue_id])}}"> <b property="name">{{$event->venue->venue_name}}</b></a>
                        <meta property="address" content="{{ urldecode($event->venue->venue_name) }}"></p>
                    @include('mobile.Partials.Schedule')
                </div>
            </div>
        </div>
    </section>
    <section id="location" class="container p0" style="margin-bottom: 50px">
        <div class="row">
            <div class="col-md-12">
                <div class="google-maps content" id="map" style="height: 250px">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('after_scripts')
<script>
    function initMap() {
        var uluru = {lat: {{$event->venue->address['latlng']['lat']}}, lng: {{$event->venue->address['latlng']['lng']}}};
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
