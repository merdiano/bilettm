@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('search')}}
    <section class="movie-items-group firts-child" style="margin-bottom: 100px">
        <div class="container">
            <div class="row kinoteator tab-part">
                <div class="tab-header d-flex justify-content-between col-12">
                    <h2 class="">@lang('ClientSide.search_result') : {{$query}}</h2>
                    <div style="height: 5px; margin-left: 5px; position: absolute; bottom: 0px; width: 100px; background-color: rgba(211,61,51,1)"></div>
                </div>
                <div class="tab-ozi col-12">
                    <!-- Nav tabs -->
                    <ul class="nav u-nav-v1-1 g-mb-20" role="tablist" data-target="nav-1-1-default-hor-left" data-tabs-mobile-type="slide-up-down" data-btn-classes="btn btn-md btn-block rounded-0 u-btn-outline-lightgray g-mb-20">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" role="tab">{{__("ClientSide.results")}}: {{$events->count()}}/{{$events->total()}}</a>
                        </li>
                    </ul>
                    <!-- End Nav tabs -->
                </div>
            </div>
            <div class="row">
                @foreach($events as $event)
                    <div class="col-4 mb-2">
                        <div class="row">
                            <div class="col-4">
                                <img class="w-100 img-responsive" src="{{asset($event->images->first()->image_path ?? '#')}}" alt="{{$event->title}}"/>
                            </div>
                            <div class="col-8">
                                <h4 class="film_name"><a href="{{$event->event_url}}">{{$event->title}}</a></h4>
                                <h6 class="text-left">@lang('ClientSide.category') : {{$event->category_title}}</h6>
                                <h6 class="text-left">@lang('ClientSide.venue') : {{$event->venue_name}}</h6>
                                <h6 class="text-left">@lang('ClientSide.date') : {{$event->start_date->format('d.m.Y')}} - {{$event->end_date->format('d.m.Y')}}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                {{$events->links('vendor.pagination.simple-bootstrap-4')}}
            </div>
        </div>
    </section>
@endsection
