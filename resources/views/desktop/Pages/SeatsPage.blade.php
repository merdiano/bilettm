@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('seats',$event)}}
    <section class="mb-4 container">
        <h1 class="mt-4" >{{__('ClientSide.by_ticket_for', ['event'=>$event->title_])}}</h1>
        <h6 class="mb-5 g-brd-bottom text-left" >{{$venue->venue_name}}</h6>
        <h2 class="pt-3 my-4" >{{__('ClientSide.step')}} 1. {{__('ClientSide.checkout_schema')}} </h2>
        <button type="button" class="btn btn-outline-danger btn-lg px-5 py-3 seats-map" data-toggle="modal" data-target="#exampleModal">
            @lang("Public_ViewEvent.seats_map")
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 800px">
                <div class="modal-content" style="background-color: unset; border: none; ">
                    <div class="modal-header" style="border-bottom: none">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                style="border: 2px solid #ffffff; border-radius: 100px; padding: 0; opacity: 1">
                                            <span aria-hidden="true"
                                                  style="color: #ffffff; opacity: 1; text-shadow: none; font-weight: lighter; font-size: 35px; padding: 0px !important; width: 30px; height: 30px; display: block; line-height: 31px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img class="img-responsive" src="{{asset('user_content/'.$event->venue->seats_image)}}" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>

        @include('desktop.Venues.'.$venue->type)
    </section>
@endsection

