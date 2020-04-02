@if(!empty($category->events) && $category->events->count()>0)
<section id="cartoon" class="kinoteator-section waaa container mb-5">
    <div class="tab-header d-flex justify-content-between col-12 px-0">
        <h2> <a class="text-dark text-uppercase" href="{{$category->url}}">{{$category->title}}</a></h2>
        <div style="height: 5px; position: absolute; bottom: 0; width: 100px; background-color: rgba(211,61,51,1)"></div>
    </div>
    <div class="tab-ozi col-12 px-0 mt-5">

        <div class="owl-carousel" id="cartoon-tab1">
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
@endif
