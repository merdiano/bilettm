<div class="mob-top-slider">
    <div class="owl-carousel owl-theme" id="mob-top-slider">
        @foreach($sliders as $slider)
        <div class="item">
            <div class="bg-img" style="background-image: url({{asset($slider->image)}}); padding-top: 41%;">
            </div>
        </div>
        @endforeach
    </div>
</div>
