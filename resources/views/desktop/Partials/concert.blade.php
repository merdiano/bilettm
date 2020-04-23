<section id="konserty" class="container" style="background-image: url({{asset('assets/images/bg/konserty.jpg')}});
        background-repeat: no-repeat; background-size: 100%;">
    <div class="tab-header d-flex justify-content-between col-12">
        <h2 class=""><a class="text-dark text-uppercase" href="{{$category->url}}">{{$category->title}}</a></h2>
        <div style="height: 5px; margin-left: 5px; position: absolute; bottom: 0px; width: 100px; background-color: #ffffff"></div>
    </div>
    <div class="tab-ozi col-12">
       <!-- End Nav tabs -->
        <div class="owl-carousel container row" id="konserty-tab1" style="padding: 0 !important; margin: 0">

            <div class="slider-slider row">
                @foreach($category->events->slice(0,4) as $event)
                    <div class="col-3">
                        @include('desktop.Partials.MusicalItem',['event'=>$event])
                    </div>
                @endforeach
            </div>
            @if($category->events->count()>4)
                <div class="slider-slider row">
                    @foreach($category->events->slice(4) as $event)
                        <div class="col-3">
                            @include('desktop.Partials.MusicalItem',['event'=>$event])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

