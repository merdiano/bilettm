<article class="u-block-hover">
    <div class="g-bg-cover">
        <imgg class="d-flex align-items-end" style="display: block; background-image: url({{asset($event->image_url ?? '#')}}); background-position: center center; background-size: cover; padding-top: 125.628140%; border-radius: 5px"></imgg>
    </div>
    <div class="u-block-hover__additional--partially-slide-up h-100 text-center g-z-index-1 mt-auto" style="background-image: url({{asset('assets/images/overlay/1.svg')}})">
        <div class="overlay-details">
            <h2 class="title">{{$event->title}}</h2>
            <h4 class="date">{{__("ClientSide.starting")}} {{Str::limit($event->start_date->formatLocalized('%d %B'), 6 ,'.')}} </h4>
            @if(isset($size))
            <p class="description">{!! Markdown::parse($event->description) !!}</p>
            @endif
            <div class="overlay-details-bottom-part">
                <a href="" class="like">
                    <i class="fa fa-eye"></i>
                    {{$event->views}} {{__("ClientSide.views")}}</a>
                <div class="buy-btn-wrap">
                    <a href="{{$event->event_url}}" class="buy-btn">{{__("ClientSide.buy_ticket")}}</a>
                </div>

            </div>
        </div>
    </div>
</article>
