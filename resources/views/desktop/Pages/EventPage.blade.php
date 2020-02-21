@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
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
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('event',$event)}}
    <section style="margin-top: 30px; margin-bottom: 50px">
        <div class="container">
            <div class="row mb-2">
                <div class="col-10">
                    <h2 class="main-title" style="float: left">«{{$event->title}}»</h2>
                    <div class="main-title-bottom-line" style="float: left"></div>

                </div>
                <div class="col-2">
                    @include('desktop.Partials.EventShareButtons')
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    @if($event->images->count())
                        <img class="details-image" alt="{{$event->title}}" src="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}">

                    @endif
                </div>
                <div class="col-7 ">
                    <div class="it-detail">
                        {!! Markdown::parse($event->description) !!}
                        <span property="location" typeof="Place">
                                        <i class="fa fa-map-marker"></i>
                                        <b property="name">{{$event->venue->venue_name}}</b>
                                        <meta property="address" content="{{ urldecode($event->venue->venue_name) }}">
                                    </span>
                    </div>
                    @include('desktop.Partials.Schedule')

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
