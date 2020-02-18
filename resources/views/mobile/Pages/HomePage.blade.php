@extends('Shared.Layouts.BilettmLayout',['folder'=>'mobile'])
@section('after_styles')
    <link rel="stylesheet" href="{{asset('vendor/slick-carousel/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link  rel="stylesheet" href="{{asset('vendor/jquery-ui/themes/base/jquery-ui.min.css')}}">
    <style>
        .owl-carousel .owl-dots{
            display: none !important;
        }
        .overlay-details.smalll{
            position: absolute;
            bottom: 0;
        }
        .section-section .owl-stage{
            padding-left: 70px !important;
            padding-right: 70px !important;
        }
        .konserty h5{
            color: #ffffff !important;
        }
        .section-section .owl-nav{
            display: none !important;
        }

    </style>
@endsection
@section('content')

    @include('mobile.Partials.HomeSlider')

    @if(isset($cinema) && !empty($cinema->events) && $cinema->events->count()>0)
        <div class="section-section py-5">
        @include('mobile.Partials.HomeEventList',['category'=>$cinema])
        </div>
    @endif

    @if(isset($musical) && !empty($musical->events) && $musical->events->count()>0)
        <div class="section-section py-5 konserty"
             style="background-image: url({{asset('assets/images/bg/konserty.jpg')}});
                     background-repeat: no-repeat; background-size: cover; padding: 100px 0;">
        @include('mobile.Partials.HomeEventList',['category'=>$musical])
        </div>
    @endif

    @if(isset($cartoon) && !empty($cartoon->events) && $cartoon->events->count()>0)
        <div class="section-section py-5">
        @include('mobile.Partials.HomeEventList',['category'=>$cartoon])
        </div>
    @endif

@endsection
@section('after_scripts')
    <script src="{{asset('vendor/jquery-migrate/jquery-migrate.min.js')}}"></script>
    <!-- JS Implementing Plugins -->
    <script src="{{asset('vendor/slick-carousel/slick/slick.js')}}"></script>
    <script src="{{asset('vendor/dzsparallaxer/dzsparallaxer.js')}}"></script>
    <!-- JS Unify home teatr slider un ulanan sliderimin scriptleri -->
    <script src="{{asset('assets/javascript/hs.core.js')}}"></script>
    <script src="{{asset('assets/javascript/components/hs.carousel.js')}}"></script>
    <script src="{{asset('vendor/owlcarousel/owl.carousel.min.js')}}"></script>
    <!-- JS Unify -->
    <script src="{{ asset('assets/javascript/components/hs.select.js') }}"></script>
{{--    <script src="{{ asset('assets/javascript/components/hs.datepicker.js') }}"></script>--}}
    <!-- JS Plugins Init. -->
    <script>

        //owl carousel
        $("#mob-top-slider").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
        });

        $(".owl-carousel").owlCarousel({
            stagePadding: 70,
            loop:true,
            margin:10,
            nav:false,
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

        $(document).ready(function(){
            $("#slide-teator-prev").click(function(){
                $("#carousel-09-1 .js-prev").click();
            });
            $("#slide-teator-next").click(function(){
                $("#carousel-09-1 .js-next").click();
            });

            $('.header-search-a').click(function () {
                $('.navbar-toggler').click();
                $('.search-input-box').focus();

            })
        });

    </script>

@endsection
