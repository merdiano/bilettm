<div class="col-4">
    <article class="u-block-hover">
        <div class="g-bg-cover">
            <imgg class="d-flex align-items-end" style="border-radius: 5px; background-image: url({{asset($event->image_url ?? '#')}}); background-position: center center; background-size: cover; padding-top: 56.902985%"></imgg>
        </div>
        <div class="u-block-hover__additional--partially-slide-up h-100 text-center g-z-index-1 mt-auto" style="background-image: url({{asset('assets/images/bg/teatr.png')}})">
            <div class="overlay-details smalll">
                <span class="">{{$event->start_date->format('H:s d.m.Y')}}</span>
                <h1 style="font-size: 30px; font-weight: bold">{{$event->title}}</h1>
                <a href="" style="border: 1px solid #ffffff; padding: 7px 25px; border-radius: 5px">Купит билет</a>
                <span style="display: block; width: 100%; padding-top: 10px">Цена: от 40 TMT</span>
            </div>
        </div>
    </article>
</div>