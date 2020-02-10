@extends('Bilettm.Layouts.BilettmLayout')
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
            <div class="row m-0">
                <div class="col-12">
                    <div class="container" style="padding: 0 !important;">
                        <div class="row">
                            <div class="col-12 p-0" style="margin-bottom: 10px">
                                <h2 class="main-title" style="float: left">«{{$event->title}}»</h2>
                                <div class="main-title-bottom-line" style="float: left"></div>
                                @include('Bilettm.ViewEvent.Partials.EventShareButtons')
                            </div>
                            <div class="col-12 p-0 it-detail" style="padding-left: 10px !important;">
                                @if($event->images->count())
                                    <imgg style="display: block; background-image: url({{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}); background-position: center center; background-size: cover; padding-top: 30.4223%; width: 24.2161%; border-radius: 0" class="details-image" alt="{{$event->title}}" property="image"></imgg>
{{--                                    <button style="width: 24.2161%; clear: left; background-color: rgb(212, 61, 52); color: #ffffff; border: none; height: 41.6px; border-radius: 5px; float: left">Купить билет</button>--}}

                                @endif
                                <div class="col-10">
                                    {!! Markdown::parse($event->description) !!}
                                </div>

{{--                                    <b>{{$event->organiser->name}}</b> @lang("Public_ViewEvent.presents")--}}
{{--                                    @lang("Public_ViewEvent.at")--}}
                                    <span property="location" typeof="Place">
                                        <i class="fa fa-map-marker"></i>
                                        <b property="name">{{$event->venue->venue_name}}</b>
                                        <meta property="address" content="{{ urldecode($event->venue->venue_name) }}">
                                    </span>
                                    @include('Bilettm.ViewEvent.Partials.Schedule')
                            </div>
                            {{--<div class="col-6 p-0">--}}
                            {{--@include('Bilettm.ViewEvent.Partials.Schedule')--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
                {{--<div class="col-2 text-center">--}}

                    {{--@include('Bilettm.ViewEvent.Partials.EventShareButtons')--}}
                    {{--<img src="{{asset('assets/images/advs/adv.png')}}" style="width: 100%">--}}

                {{--</div>--}}
                {{--<div class="col-12 p-0">--}}
                    {{--@include('Bilettm.Partials.EventTags')--}}
                {{--</div>--}}
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
