<div class="js-slide">
    <a class="d-block" href="{{$event->event_url}}">
        <img class="img-fluid w-100" src="{{asset($event->image_url ?? '#')}}">
        <div class="teator-overlay">
            <div class="texts-wrapper" style="color: #ffffff">
                <span class="" style="font-size: 30px">{{$event->start_date->format('H:s, d.m.Y')}}</span>
                <h2 style="font-size: 60px; line-height: 1">{{$event->title}}</h2>
                <h5 style="margin-bottom: 20px">{{$event->venue_name}}</h5>
                <span style="color: #ffffff; font-weight: bold; border: 1px solid #ffffff; border-radius: 5px; padding: 10px 30px; font-size: 20px">Купит билет</span>
                <span style="color: #ffffff; font-size: 20px; width: 100%; margin-top: 10px; display: block">Цена: от 40 TMT</span>
            </div>
        </div>
    </a>
</div>