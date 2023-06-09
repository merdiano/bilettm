<article class="u-block-hover">
    <div class="g-bg-cover">
        <img class="d-flex align-items-end" style="display: block; background-image: url({{asset($event->image_url ?? '#')}}); background-position: center center; background-size: cover; padding-top: 125.628140%; border-radius: 5px"/>
    </div>
    <div class="u-block-hover__additional--partially-slide-up h-100 text-center g-z-index-1 mt-auto"
         style="background-image: url({{asset('assets/images/overlay/1.svg')}})">
        <div class="overlay-details">
            <a href="{{$event->event_url}}">
                <h2 class="title">{{$event->title}}</h2>
            </a>
            <a href="{{$event->event_url}}">
                <h4 class="date">{{$event->start_date->formatLocalized('%d %B %H:%M')}}</h4>
            </a>
            @if(isset($size))
            <p class="description">{!! Markdown::parse($event->description) !!}</p>
            @endif
            <div class="overlay-details-bottom-part">
                <a href="{{$event->event_url}}" class="like">
                    <i class="fa fa-eye"></i>
                    {{$event->views??0}} {{__("ClientSide.views")}}</a>

            </div>
        </div>
    </div>
</article>
