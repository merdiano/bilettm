@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('vendor/slick-carousel/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link  rel="stylesheet" href="{{asset('vendor/jquery-ui/themes/base/jquery-ui.min.css')}}">
@endsection
@section('content')

    <div class="section-section py-3">
        <div class="col-12 d-flex justify-content-between">
            <h5 >{{$category->title}}
                <div class="title-bottom-line"></div>
            </h5>
            <a class="red_button" href="{{$category->url}}">{{__("ClientSide.rep")}}</a>
        </div>
        <div class="row mt-2">
            @include("Shared.Partials.FilterMenu")
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
    <script src="{{asset('vendor/slick-carousel/slick/slick.js')}}"></script>
    <script src="{{asset('vendor/owlcarousel/owl.carousel.min.js')}}"></script>

    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            icons: {
                rightIcon: '{{__("ClientSide.date")}} <i class="fa fa-caret-down"></i>'
            }
        });
        $('.owl-carousel').owlCarousel({
            stagePadding: 70,
            loop:true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
    </script>

@endsection
