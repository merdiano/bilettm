@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])

@section('content')

    {{--    @include('desktop.ViewEvent.Partials.HeaderSection')--}}
    {{--@include('Public.ViewEvent.Partials.EventShareSection')--}}
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 property="name" style="font-weight: bold">Bagyshlan</h1>
                <p>
                    Toleginiz barada maglumatlar entak gelenok. gelenson biletleri emailinize 10 minudyn dowamynda ugradarys.
                    egerde bu wagt caginde biletleriniz gelmedik bolsa administrasia yuz tutmagynyzy hayys edyaris.
                </p>
            </div>
        </div>
    </section>


@stop
