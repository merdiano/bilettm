<section class="main-top-slider fadeOut owl-carousel owl-theme" id="main-top-slider">
    @foreach($sliders as $slider)
        <div class="item">
            <li style="padding-top: 31.25%"
                class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall"
                data-index="rs-2800"
                data-transition="slidingoverlayhorizontal"
                data-slotamount="default"
                data-hideafterloop="0"
                data-hideslideonmobile="off"
                data-easein="default"
                data-easeout="default"
                data-masterspeed="default"
                data-rotate="0"
                data-saveperformance="off"
                data-title="{{$slider->title}}">
                <!-- Parallax Image -->
                <div class="divimage dzsparallaxer--target w-100"
                    style="position:absolute; top: 0; background-position: center center;
                            background-size: 100%; bottom: -100px; background-image:
                            url(/user_content/{{$slider->image}}); transform: unset !important;"></div>

                <!-- End Parallax Image -->
                <a href="{{$slider->link ?? '#'}}" class="d-block container g-py-200 h-100" style="top: 0; bottom: 0; left: 0; right: 0; position:absolute;"></a>
            </li>              @if($slider->link)
            <div class="slider-content" style="position: absolute; bottom: 200px; right: 200px; padding: 20px;">
                <a href="{{$slider->link}}" class="btn btn-danger btn-lg">
                    {{$slider->title}}
                </a>
            </div>
            @endif
        </div>
    @endforeach
</section>
