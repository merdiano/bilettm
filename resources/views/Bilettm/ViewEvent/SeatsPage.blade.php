@extends('Bilettm.Layouts.BilettmLayout')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('seats',$event)}}
    <section style="margin-bottom: 80px">
        <div class="container">
            <a class="mobile_pt_30 mobile_pb0 collapsed d-flex justify-content-between g-color-main g-text-underline--none--hover g-brd-bottom g-brd-gray-light-v4 g-pa-15-0" href="#accordion-10-body-02" data-toggle="collapse" data-parent="#accordion-10" aria-expanded="false" aria-controls="accordion-10-body-02">
                <span class="d-flex">
                    <h1 class="mobile_header_tab" style="font-weight: 600;font-size: 35px;">Choose seats</h1>
                </span>
            </a>
            <div class="row">
                <div class="col-md-12">
                    <div class="pills-struct mt-5">
                        <ul role="tablist" class="nav nav-pills m-auto w-auto justify-content-center" id="choose_seats">
                            @foreach($tickets as $ticket)
                                <li class="active" role="presentation" style="display: inline-block;">
                                    <a aria-expanded="true" data-toggle="tab" class="@if ($loop->first)active @endif show"
                                       role="tab" id="home_tab_{{$ticket->id}}" href="#home_{{$ticket->id}}" aria-selected="true">
                                        {{$ticket->title}} - {{$ticket->price}} man.</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="d-flex justify-content-center mt-5 mb-4">
                            <span class="mx-3" style="font-size: 18px"><i class="fa fa-circle" style="color: #ebeced; font-size: 13px"></i> Available</span>
                            <span class="mx-3" style="font-size: 18px"><i class="fa fa-circle" style="color: #69687d; font-size: 13px"></i> Booked</span>
                            <span class="mx-3" style="font-size: 18px"><i class="fa fa-circle" style="color: #b6b6b6; font-size: 13px"></i> Reserved</span>
                            <span class="mx-3" style="font-size: 18px"><i class="fa fa-circle" style="color: #ff4159; font-size: 13px"></i> Your Selection</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="width: 100%" height="137.997" viewBox="0 0 1120 137.997">
                            <defs>
                                <linearGradient id="linear-gradient" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                                    <stop offset="0" stop-color="#f6f6f6"/>
                                    <stop offset="1" stop-color="#fff"/>
                                </linearGradient>
                            </defs>
                            <g id="Screen_and_acupation" data-name="Screen and acupation" transform="translate(-163 -1257)">
                                <g id="Group_16" data-name="Group 16" transform="translate(163 1257)">
                                    <path id="Path_2" data-name="Path 2" d="M0,126.055s347.577-9.015,494.7-9.015,494.7,9.015,494.7,9.015L985.545,10.807S683.323,0,496.656,0,7.767,10.807,7.767,10.807Z" transform="translate(63.344 11.942)" opacity="0.5" fill="url(#linear-gradient)"/>
                                    <path id="Path_2-2" data-name="Path 2" d="M63.344,18.577s347.577-6.5,494.7-6.5,494.7,6.5,494.7,6.5L1120,7.394S746.667,0,560,0,0,7.394,0,7.394Z" fill="#ebeced"/>
                                </g>
                            </g>
                        </svg>
                        <div class="tab-content" id="choose_seats_content">
                            @include('Bilettm.ViewEvent.Partials.Seats')
                        </div>
                        <div class="checked-seats" style="padding: 30px 0; text-align: center">
                            <h5 style="text-align: center; font-weight: bold;">You Have Selected <span>4</span> Seats</h5>
                            <h5 style="text-align: center;">Your Seats:</h5>
                            <form action="{{route('postValidateTickets',['event_id'=>$event->id])}}" method="post">
                            @csrf
                                <div class="your-selected-seats" style="text-align: center; margin-bottom: 50px">
                                    <span>G-12</span>
                                    <span>G-13</span>
                                    <span>G-14</span>
                                    <span>G-15</span>
                                </div>
                            <a id="confirm-seats">Confirm seats</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('after_scripts')
    @include("Shared.Partials.LangScript")
    {!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}
@endsection