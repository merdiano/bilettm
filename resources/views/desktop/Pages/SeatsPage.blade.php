@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('seats',$event)}}
    <section class="mb-4 container">
        <h1 class=" display-5 g-brd-bottom py-3 mt-4 font-weight-bold" >{{$event->title}}</h1>
        <h2 class="py-1 mb-5" >{{$venue->venue_name}}</h2>

        <div class="row">
            <div class="col-md-12">
                <h1 class="pt-5 font-weight-bold" >{{__('ClientSide.seats')}} {{$ticket_date}}</h1>
                <h2 class="pt-3 my-4" >{{__('ClientSide.step')}} 1. {{__('ClientSide.checkout_schema')}} </h2>
                <button type="button" class="btn btn-outline-dark btn-lg px-5 py-3 seats-map" data-toggle="modal" data-target="#exampleModal">
                    @lang("Public_ViewEvent.seats_map")
                </button>

            </div>
        </div>
        @include('desktop.Venues.'.$venue->type)
    </section>
@endsection

