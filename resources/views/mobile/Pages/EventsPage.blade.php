@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @foreach($sub_cats as $cat)

        <div class="section-section py-3">
            <div class="container" style="padding: 0 5% !important;">
                <div class="row">
                    <div class="col-12 d-flex justify-content-between">
                        <h5 >{{$cat->title}}
                            <div class="title-bottom-line"></div>
                        </h5>

{{--                        <a class="red_button" href="{{$cat->url}}">{{__("ClientSide.rep")}}</a>--}}
                    </div>
                    @include("Shared.Partials.FilterMenu")

                </div>
            </div>
            <div class="owl-carousel owl-theme" id="section-slider{{$loop->iteration}}">
                @foreach($cat->cat_events as $event)
                    @include('mobile.Partials.EventListItem')
                @endforeach
            </div>
        </div>

    @endforeach

@endsection
@section('after_scripts')

    <script src="{{asset('vendor/gijgo/gijgo.min.js')}}" type="text/javascript"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            icons: {
                rightIcon: '{{__("ClientSide.date")}} <i class="fa fa-caret-down"></i>'
            }
        });
    </script>

@endsection
