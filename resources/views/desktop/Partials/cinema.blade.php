@section('after_styles')
    <link href="{{asset('vendor/gijgo/gijgo.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('vendor/slick-carousel/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link  rel="stylesheet" href="{{asset('vendor/jquery-ui/themes/base/jquery-ui.min.css')}}">
@endsection

<section id="kinoteator" class="kinoteator-section waaa container mb-5">
    <div class="tab-header d-flex justify-content-between col-12 px-0">
        <h2> <a class="text-dark text-uppercase" href="{{$category->url}}">{{$category->title}}</a></h2>

        <div style="height: 5px; position: absolute; bottom: 0; width: 100px; background-color: rgba(211,61,51,1)"></div>
    </div>
    <div class="tab-ozi col-12 px-0 mt-5">

        <div class="owl-carousel" id="kinoteator-tab1">
            <div class="row">
                @foreach($category->events->slice(0,8) as $event)
                    <div class="col-3 pb-4">
                        @include('desktop.Partials.CinemaItem',['event'=>$event])
                    </div>
                @endforeach
            </div>
            @if($category->count()>8)
                <div class="row">
                    @foreach($category->events->slice(8) as $event)
                        <div class="col-3 pb-4">
                            @include('desktop.Partials.CinemaItem',['event'=>$event])
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>

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