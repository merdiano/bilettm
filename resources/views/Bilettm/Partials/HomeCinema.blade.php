@if(!empty($cinema->events) && $cinema->events->count()>0)
<section id="kinoteator" class="kinoteator-section container">
    <div class="tab-header d-flex justify-content-between col-12 px-0">
        <h2 class="">{{$cinema->title}}</h2>
        <div style="height: 5px; position: absolute; bottom: 0; width: 100px; background-color: rgba(211,61,51,1)"></div>
        <a class="" href="{{$cinema->url}}">{{__('ClientSide.view')}}</a>
    </div>
    <div class="tab-ozi col-12 px-0">

        <div class="owl-carousel container row" id="kinoteator-tab1" style="padding: 0 !important; margin: 0">
            <div class="slider-slider">
                <div class="row w-100 m-auto">
                    <div class="col-6 single-item-6 big-cinema-item-col6">
                        @include('Bilettm.Partials.CinemaItem',['event'=>$cinema->events->first(),'size'=>'big'])
                    </div>
                    <div class="col-6" style="padding: 0">
                        <div class="row">
                            @foreach($cinema->events->slice(1,4) as $event)
                            <div class="col-6 single-item-6">
                                @include('Bilettm.Partials.CinemaItem',['event'=>$event])

                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            @if($cinema->count()>4)
                <div class="slider-slider">
                    <div class="row">
                        @foreach($cinema->events->slice(5) as $event)
                            <div class="col-6 single-item-6">
                                @include('Bilettm.Partials.CinemaItem',['event'=>$event])
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
@endif