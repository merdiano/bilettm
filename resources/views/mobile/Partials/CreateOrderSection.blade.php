<section id='order_form' class="container-fluid">
    <div class="row justify-content-center my-3" style="background-color: rgba(211,61,51,1)">
        <h3 class="section_head text-light">
            @lang("Public_ViewEvent.order_details")
        </h3>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body pt0">
                    <h3 class="card-title">
                        <i class="ico-cart mr5"></i>
                        @lang("Public_ViewEvent.order_summary")
                    </h3>
                    <table class="table mb0 table-condensed">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="text-align: right;">@lang('Public_ViewEvent.booking_fees')</th>
                            <th style="text-align: right;">@lang('Public_ViewEvent.price')</th>
                        </tr>
                        </thead>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td class="pl0">{{{$ticket['ticket']['title']}}} x <b>{{$ticket['qty']}}</b></td>
                                <td style="text-align: right; font-size: 20px">{{money($ticket['total_booking_fee'], $event->currency)}}</td>
                                <td style="text-align: right; font-size: 20px">
                                    @if((int)ceil($ticket['original_price']) === 0)
                                        @lang("Public_ViewEvent.free")
                                    @else
                                        {{ money($ticket['original_price'], $event->currency) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if($order_total > 0)
                    <div class="card-footer">
                        <h5>
                            @lang("Public_ViewEvent.total"): <span style="float: right;width: fit-content"><b>{{ $orderService->getOrderTotalWithBookingFee(true) }}</b></span>
                        </h5>
                        @if($event->organiser->charge_tax)
                            <h5>
                                {{ $event->organiser->tax_name }} ({{ $event->organiser->tax_value }}%):
                                <span style="float: right;width: fit-content"><b>{{ $orderService->getTaxAmount(true) }}</b></span>
                            </h5>
                            <h5>
                                <strong>@lang("Public_ViewEvent.grand_total")</strong>
                                <span style="float: right; width: fit-content"><b>{{  $orderService->getGrandTotal(true) }}</b></span>
                            </h5>
                        @endif
                    </div>
                @endif

            </div>
            <div class="help-block my-4 ">
                {!! @trans("Public_ViewEvent.time", ["time"=>"<span id='countdown'></span>"]) !!}
            </div>
        </div>
        <div class="col-12">
            <div class="event_order_form card py-3 px-md-5">
                {!! Form::open(['url' => route('postCreateOrder', ['event_id' => $event->id]),
                'class' => ($order_requires_payment && @$payment_gateway->is_on_site) ? 'ajax payment-form' : 'ajax', 'data-stripe-pub-key' => isset($account_payment_gateway->config['publishableKey']) ? $account_payment_gateway->config['publishableKey'] : '']) !!}

                {!! Form::hidden('event_id', $event->id) !!}

                <h4> @lang("Public_ViewEvent.your_information")</h4>

                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label("order_first_name", trans("Public_ViewEvent.first_name")) !!}
                            {!! Form::text("order_first_name", null, ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label("order_last_name", trans("Public_ViewEvent.last_name")) !!}
                            {!! Form::text("order_last_name", null, ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12">
                        <div class="form-group">
                            {!! Form::label("order_email", trans("Public_ViewEvent.email")) !!}
                            {!! Form::text("order_email", null, ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="p20 pl0">
                    <a href="javascript:void(0);" class="btn btn-sm w-100" id="mirror_buyer_info" style="background-color: rgba(211,61,51,1); color: #ffffff; padding: 7px 0px; ">
                        @lang("Public_ViewEvent.copy_buyer")
                    </a>
                </div>

                <div class="row mt-5">
                    <div class="ticket_holders_details" >
                        <?php
                        $total_attendee_increment = 0;
                        ?>
                        @foreach($tickets as $ticket)
                            @foreach($ticket['seats'] as  $seat)

                                <div class="card card-info my-2">

                                    <div class="card-header">
                                        <h5 class="card-title text-center">
                                            @lang("Public_ViewEvent.seat_holder_n", ["seat_no"=>$seat,'ticket'=>"{$ticket['ticket']['title']}"])
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_first_name[{$seat}][{$ticket['ticket']['id']}]", trans("Public_ViewEvent.first_name")) !!}
                                                    {!! Form::text("ticket_holder_first_name[{$seat}][{$ticket['ticket']['id']}]", null, ['required' => 'required', 'class' => "ticket_holder_first_name.$seat.{$ticket['ticket']['id']} ticket_holder_first_name form-control"]) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_last_name[{$seat}][{$ticket['ticket']['id']}]", trans("Public_ViewEvent.last_name")) !!}
                                                    {!! Form::text("ticket_holder_last_name[{$seat}][{$ticket['ticket']['id']}]", null, ['required' => 'required', 'class' => "ticket_holder_last_name.$seat.{$ticket['ticket']['id']} ticket_holder_last_name form-control"]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {!! Form::label("ticket_holder_email[{$seat}][{$ticket['ticket']['id']}]", trans("Public_ViewEvent.email_address")) !!}
                                                    {!! Form::text("ticket_holder_email[{$seat}][{$ticket['ticket']['id']}]", null, ['required' => 'required', 'class' => "ticket_holder_email.$seat.{$ticket['ticket']['id']} ticket_holder_email form-control"]) !!}
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    {!! Form::checkbox("order_terms", true, true,['required' => 'required', 'class' => 'form-control','style'=>'width:fit-content;display:inline-block;margin-right:10px']) !!}
                                                    <a style="color: #000000;" target="_blank" href="{{route('about',['page'=>'oferta'])}}">@lang('ClientSide.terms_conditions')</a>
                                                </div>
                                            </div>
                                            @include('Public.ViewEvent.Partials.AttendeeQuestions', ['ticket' => $ticket['ticket'],'attendee_number' => $total_attendee_increment++])

                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <style>
                    .offline_payment_toggle {
                        padding: 20px 0;
                    }
                </style>

                @if($event->pre_order_display_message)
                    <div class="well well-small">
                        {!! nl2br(e($event->pre_order_display_message)) !!}
                    </div>
                @endif

                {!! Form::hidden('is_embedded', $is_embedded) !!}
                {!! Form::submit(trans("Public_ViewEvent.checkout_submit"), ['class' => 'check-order-btn btn btn-lg btn-danger card-submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>


    </div>
</section>
