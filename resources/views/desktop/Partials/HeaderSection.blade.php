<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 property="name" style="font-weight: bold">{{$event->title}}</h1>
        </div>
    </div>
</section>
<section id="organiserHead" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div onclick="window.location='{{$event->event_url}}#organiser'" class="event_organizer text-center p-3">
                     <b>{{$event->venue->venue_name}}</b> @lang("Public_ViewEvent.presents")
                </div>
            </div>
        </div>
    </div>
</section>
