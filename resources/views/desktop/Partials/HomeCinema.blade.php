@if(!empty($category->events) && $category->events->count()>0)
<section id="{{$id}}" class="kinoteator-section waaa container">
    <div class="tab-header d-flex justify-content-between col-12 px-0">
        <h2 class="">{{$category->title}}</h2>
        <div style="height: 5px; position: absolute; bottom: 0; width: 100px; background-color: rgba(211,61,51,1)"></div>
        <a class="" href="{{$category->url}}">{{__('ClientSide.view')}}</a>
    </div>
    <div class="tab-ozi col-12 px-0">

        <div class="owl-carousel container row" id="{{$id}}-tab1" style="padding: 0 !important;">
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
                        <div class="col-3">
                            @include('desktop.Partials.CinemaItem',['event'=>$event])
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>
@endif
