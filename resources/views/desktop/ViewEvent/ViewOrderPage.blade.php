@extends('desktop.Layouts.BilettmLayout')

@section('content')

{{--    @include('desktop.ViewEvent.Partials.HeaderSection')--}}
    {{--@include('Public.ViewEvent.Partials.EventShareSection')--}}
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 property="name" style="font-weight: bold">{{$event->title}}</h1>
            </div>
        </div>
    </section>
    @include('desktop.ViewEvent.Partials.ViewOrderSection')
    @include('desktop.ViewEvent.Partials.FooterSection')

@stop
