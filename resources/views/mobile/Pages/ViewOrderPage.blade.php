@extends('Shared.Layouts.BilettmLayout',['folder' => 'mobile'])

@section('content')

{{--    @include('desktop.ViewEvent.Partials.HeaderSection')--}}
    {{--@include('Public.ViewEvent.Partials.EventShareSection')--}}
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 property="name" style="font-weight: bold">{{$event->title}}</h3>
            </div>
        </div>
    </section>

<section id="order_form" class="container">
    <div class="row">
        <div class="col-md-12 order_header">
            <span class="massive-icon">
                <i class="ico ico-checkmark-circle"></i>
            </span>
            <h4>@lang("Public_ViewEvent.thank_you_for_your_order")</h4>
            <h4>
                @lang("Public_ViewEvent.your")
                {{-- <a class="ticket_download_link"
                   href="{{ route('showOrderTickets', ['order_reference' => $order->order_reference] ).'?download=1' }}">
                    @lang("Public_ViewEvent.tickets") </a>  @lang("Public_ViewEvent.confirmation_email") --}}
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($event->post_order_display_message)
                <div class="alert alert-dismissable alert-info">
                    {{ nl2br(e($event->post_order_display_message)) }}
                </div>
            @endif
                <div class="row mt-3">
                    <div class="col-5">
                        <b>@lang("Attendee.first_name")</b><br> <small>{{$order->first_name}}</small>
                    </div>
                    <div class="col-7">
                        <b>@lang("Attendee.last_name")</b><br> <small>{{$order->last_name}}</small>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-5">
                        <b>@lang("Public_ViewEvent.reference")</b><br> <small>{{$order->order_reference}}</small>
                    </div>
                    <div class="col-7">
                        <b>@lang("Public_ViewEvent.amount")</b><br> <small>{{number_format($order->total_amount, 2)}} man.</small>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-5">
                        <b>@lang("Public_ViewEvent.date")</b><br> <small>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</small>
                    </div>

                    <div class="col-7">
                        <b>@lang("Public_ViewEvent.email")</b><br> <small>{{$order->email}}</small>
                    </div>
                </div>


            @if(!$order->is_payment_received)
                <h3>
                    @lang("Public_ViewEvent.payment_instructions")
                </h3>
                <div class="alert alert-info">
                    @lang("Public_ViewEvent.order_awaiting_payment")
                </div>
                <div class="offline_payment_instructions well">
                    {!! Markdown::parse($event->offline_payment_instructions) !!}
                </div>

            @endif

        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <h5 class="mt-4">
                @lang("Public_ViewEvent.order_items")
            </h5>
        </div>


        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>
                        @lang("Public_ViewEvent.ticket")
                    </th>
                    <th>
                        @lang("Public_ViewEvent.quantity_full")
                    </th>
                    <th>
                        @lang("Public_ViewEvent.price")
                    </th>
                    <th>
                        @lang("Public_ViewEvent.booking_fee")
                    </th>
                    <th>
                        @lang("Public_ViewEvent.total")
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->orderItems as $order_item)
                    <tr>
                        <td>
                            {{$order_item->title}}
                        </td>
                        <td>
                            {{$order_item->quantity}}
                        </td>
                        <td>
                            @if((int)ceil($order_item->unit_price) == 0)
                                @lang("Public_ViewEvent.free")
                            @else
                                {{money($order_item->unit_price, $order->event->currency)}}
                            @endif

                        </td>
                        <td>
                            @if((int)ceil($order_item->unit_price) == 0)
                                -
                            @else
                                {{money($order_item->unit_booking_fee, $order->event->currency)}}
                            @endif

                        </td>
                        <td>
                            @if((int)ceil($order_item->unit_price) == 0)
                                @lang("Public_ViewEvent.free")
                            @else
                                {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                            @endif

                        </td>
                    </tr>
                @endforeach

                @if($event->organiser->charge_tax)
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            {{$event->organiser->tax_name}}
                        </td>
                        <td colspan="2">
                            {{ $orderService->getTaxAmount(true) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <b>@lang("Public_ViewEvent.total")</b>
                    </td>
                    <td colspan="2">
                        {{ $orderService->getGrandTotal(true) }}
                    </td>
                </tr>
                @if($order->is_refunded || $order->is_partially_refunded)
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <b>@lang("Public_ViewEvent.refunded_amount")</b>
                        </td>
                        <td colspan="2">
                            {{money($order->amount_refunded, $order->event->currency)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <b>@lang("Public_ViewEvent.total")</b>
                        </td>
                        <td colspan="2">
                            {{money($order->total_amount - $order->amount_refunded, $order->event->currency)}}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>

        <div class="col-12">
            <h4>
                @lang("Public_ViewEvent.order_attendees")
            </h4>

        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <tbody>
                @foreach($order->attendees as $attendee)
                    <tr>
                        <td>
                            {{$attendee->first_name}}
                            {{$attendee->last_name}}
                            (<a href="mailto:{{$attendee->email}}">{{$attendee->email}}</a>)
                        </td>
                        <td>
                            {{{$attendee->ticket->title}}}
                        </td>
                        <td>{{$attendee->seat_no}}</td>
                        <td>
                            @if($attendee->is_cancelled)
                                @lang("Public_ViewEvent.attendee_cancelled")
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@include('desktop.Partials.FooterSection')

@stop
