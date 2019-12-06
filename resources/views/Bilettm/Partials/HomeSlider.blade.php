<section class="main-top-slider fadeOut owl-carousel owl-theme" id="main-top-slider">
    @foreach($sliders as $slider)
    <div class="item">
        <li style="padding-top: 31.25%" class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll loaded dzsprx-readyall"
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
            data-title="Slide"
            data-param1="asdadasdasdasdasdasdas"
            data-description="">
            <!-- Parallax Image -->
            <div class="divimage dzsparallaxer--target w-100"
                 style="position:absolute; top: 0; background-position: center center; background-size: cover; background-image: url({{asset($slider->image)}}); transform: unset !important;"></div>
            <!-- End Parallax Image -->
            <a href="" class="d-block container g-py-200 h-100"></a>
        </li>

    </div>
    @endforeach
</section>
