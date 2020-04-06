<div class="mob-top-slider">
    <div class="owl-carousel owl-theme" id="mob-top-slider">
        @foreach($sliders as $slider)
        <div class="item">
            <div class="bg-img" style="background-image: url({{asset($slider->image)}}); padding-top: 41%;">
                <a href="{{$slider->link ?? '#'}}" class="d-block container g-py-200 h-100" style="top: 0; bottom: 0; left: 0; right: 0; position:absolute;"></a>
            </div>
            <div class="slider-content" style="position: absolute; top: 0;">
                {{$slider->text}}
            </div>
        </div>
        @endforeach
    </div>
</div>
