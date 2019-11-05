<section id="organiserHead" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div onclick="window.location='{{$event->event_url}}#organiser'" class="event_organizer text-center p-3">
                    <b>{{$event->organiser->name}}</b> @lang("Public_ViewEvent.presents")
                </div>
            </div>
        </div>
    </div>
</section>
<section id="intro" class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 property="name">{{$event->title}}</h1>
            <div class="event_venue">
                <span property="startDate" content="{{ $event->start_date->toIso8601String() }}">
                    {{ $event->startDateFormatted() }}
                </span>
                -
                <span property="endDate" content="{{ $event->end_date->toIso8601String() }}">
                     @if($event->start_date->diffInDays($event->end_date) == 0)
                        {{ $event->end_date->format('H:i') }}
                    @else
                        {{ $event->endDateFormatted() }}
                    @endif
                </span>
                @lang("Public_ViewEvent.at")
                <span property="location" typeof="Place">
                    <b property="name">{{$event->venue->venue_name}}</b>
                    <meta property="address" content="{{ urldecode($event->venue_name) }}">
                </span>
            </div>

        </div>
    </div>
</section>