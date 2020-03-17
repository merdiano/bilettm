@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])

@section('content')

    {{--    @include('desktop.ViewEvent.Partials.HeaderSection')--}}
    {{--@include('Public.ViewEvent.Partials.EventShareSection')--}}
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 property="name" style="font-weight: bold">{{$event->title}}</h1>
                <p>
                    Toleginiz baada maglumatlar entak gelenok. gelenson biletleri emailinize 15 minudyn dowamynda ugradarys.
                    egerde toleg gechibm 15 minudyn dowamynda biletleriniz gelmedik bolsa administrasia yuz tutyn.
                </p>
            </div>
        </div>
    </section>


@stop
