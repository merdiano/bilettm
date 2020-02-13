<div class="item">
    <div class="container">
        <div class="row">
            <article class="u-block-hover">
                <div class="g-bg-cover">
                    <img class="d-flex align-items-end" src="{{asset($event->image_url ?? '#')}}" style="border-radius: 5px">
                </div>
                <div class="u-block-hover__additional--partially-slide-up h-100 text-center g-z-index-1 mt-auto"
                     style="background-image: url({{asset('assets/images/bg/konserty-item.png')}})">
                    <div class="overlay-details smalll">
                        <h2 class="title">{{$event->title}}</h2>
                        <h4 class="date">{{$event->start_date->formatLocalized('%d %B %H:%M')}}</h4>
                        <div class="overlay-details-bottom-part">
                            <a href="" class="like">
                                <i class="fa fa-eye"></i>
                                {{$event->views??0}} {{__("ClientSide.views")}}</a>
                            <div class="buy-btn-wrap">
                                <a href="{{$event->event_url}}" class="buy-btn">{{__("ClientSide.buy_ticket")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
