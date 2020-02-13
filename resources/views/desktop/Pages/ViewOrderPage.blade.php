@extends('Shared.Layouts.BilettmLayout')

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
    @include('desktop.Partials.ViewOrderSection')
    @include('desktop.Partials.FooterSection')

@stop
