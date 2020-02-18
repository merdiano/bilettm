@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="section-section py-5">
        <div class="container" style="padding: 0 5% !important;">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h5>{{$category->title}}
                        <div class="title-bottom-line"></div>
                    </h5>
                </div>
                @include("Shared.Partials.FilterMenu")

            </div>
        </div>
        <div class="owl-carousel owl-theme" id="section-slider1">
            @foreach($events as $event)
                @include('mobile.Partials.EventListItem')
            @endforeach
        </div>
        <div class="pagination-wrapper">
            {{$events->appends(['sort'=>$sort,'start'=>$start,'end'=>$end])->links()}}
        </div>
    </div>
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
