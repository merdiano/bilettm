@extends('Bilettm.Layouts.BilettmLayout')
@section('after_styles')
    <link rel="stylesheet" href="{{asset('vendor/slick-carousel/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link  rel="stylesheet" href="{{asset('vendor/jquery-ui/themes/base/jquery-ui.min.css')}}">
@endsection
@section('content')

    @include('Bilettm.Partials.HomeSlider')

    @include('Bilettm.Partials.HomeCinema')

    @include('Bilettm.Partials.HomeMusical')

<section id="first-add-wrapper" style="margin: 100px 0;">
    <div class="container">
        <div class="row" style="padding: 0 20px;">
            <a href="" style="width: 100%">
                <img src="{{asset('assets/images/advs/first.png')}}" style="width: 100%">
            </a>
        </div>
    </div>
</section>

@if(isset($theatre))
    @include('Bilettm.Partials.HomeTheatre')
@endif
<section id="second-add-wrapper" style="margin: 100px 0;">
    <div class="container">
        <div class="row" style="padding: 0 20px;">
            <a href="" style="width: 100%">
                <img src="{{asset('assets/images/advs/second.png')}}" style="width: 100%">
            </a>
        </div>
    </div>
</section>
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
    <script src="{{ asset('assets/javascript/components/hs.datepicker.js') }}"></script>
    <!-- JS Plugins Init. -->
    <script>
        $.HSCore.components.HSCarousel.init('[class*="js-carousel"]');
        // initialization of custom select
        $.HSCore.components.HSSelect.init('.js-custom-select');

        // initialization of forms
        $.HSCore.components.HSDatepicker.init('#datepickerInline');
        $('#carouselCus1').slick('setOption', 'responsive', [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 992,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }], true);
        //owl carousel
        $("#main-top-slider").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
        });
        $("#kinoteator-tab1").owlCarousel({
            items: 1,
        });
        $("#konserty-tab1").owlCarousel({
            items: 1,
        })
        $("#teator-tab1").owlCarousel({
            items: 1,
        });

        $(document).ready(function(){
            $("#slide-teator-prev").click(function(){
                $("#carousel-09-1 .js-prev").click();
            });
            $("#slide-teator-next").click(function(){
                $("#carousel-09-1 .js-next").click();
            });
            // home page teatrda ulanan sliderim un script
            // initialization of carousel
            $('#date-click').click(function () {
                $('#date-click-content').toggleClass('show-content');
            });
        });
    </script>

@endsection
