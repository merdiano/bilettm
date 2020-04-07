<div class="film">
    <div class="row">
        <div class="col-md-4 col-4 col-lg-4">
            <img class="film_img img-responsive" src="{{asset($event->images->first()->image_path ?? '#')}}" alt="{{$event->title}}"/>
        </div>
        <div class="col-md-8 col-lg-8 col-8">
            <div class="film_op">
                <div class="date">
                    <div class="day">
                        <h4>{{$event->start_date->format('d.m.Y')}} - {{$event->end_date->format('d.m.Y')}}</h4>
                        <h6>{{$event->getSeansCount()}}</h6>
                    </div>
                </div>
                <h2 class="film_name"><a href="{{$event->event_url}}">{{$event->title}}</a></h2>
                <h4>{{$event->category_title}}</h4>
                <h4>{{$event->venue_name}}</h4>
                <div id="desc">
                    {!! Markdown::parse($event->description) !!}
                </div>

            </div>
        </div>
    </div>
</div>
