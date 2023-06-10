@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])

@section('content')

{{--    @include('desktop.ViewEvent.Partials.HeaderSection')--}}
    {{--@include('Public.ViewEvent.Partials.EventShareSection')--}}
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 property="name" style="font-weight: bold; padding: 25px 10px;">{{$event->title}}</h1>
            </div>
        </div>
    </section>
    @include('desktop.Partials.ViewOrderSection')
    @include('desktop.Partials.FooterSection')

@stop
