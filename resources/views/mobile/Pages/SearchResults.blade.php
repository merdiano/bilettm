@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])
@section('content')
    <section class="movie-items-group firts-child" style="margin-bottom: 100px">
        <div class="container">
            <div class="row kinoteator tab-part">
                <div class="tab-header d-flex justify-content-between col-12">
                    <h4>@lang('ClientSide.search_result') {{$query}}</h4>
                    <div style="height: 5px; margin-left: 5px; position: absolute; bottom: 0px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                </div>
                <div class="tab-ozi col-12">
                    <!-- Nav tabs -->
                    <ul class="nav u-nav-v1-1 g-mb-20">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tab">{{__("ClientSide.results")}}: {{$events->count()}}/{{$events->total()}}</a>
                        </li>
                    </ul>
                </div>
            </div>
            @foreach($events as $event)
                <div class="row mb-4" onclick="window.location.href = '{{$event->event_url}}';">
                    <div class="col-4 pr-0">
                        <img class="w-100 img-responsive" src="{{asset($event->images->first()->image_path ?? '#')}}" alt="{{$event->title}}"/>
                    </div>
                    <div class="col-8">
                        <h5 >{{$event->title}}</h5>
                        <h6 class="text-left"><b>@lang('ClientSide.category')</b>: {{$event->category_title}}</h6>
                        <h6 class="text-left"><b>@lang('ClientSide.venue')</b>: {{$event->venue_name}}</h6>
                        <h6 class="text-left"><b>@lang('ClientSide.date')</b>: {{$event->start_date->format('d.m.Y')}} - {{$event->end_date->format('d.m.Y')}}</h6>
                    </div>
                </div>
            @endforeach
            <div class="row">
                {{$events->links('vendor.pagination.simple-bootstrap-4')}}
            </div>
        </div>
    </section>
@endsection
