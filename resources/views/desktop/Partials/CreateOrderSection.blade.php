<section id='order_form' class="container">
    <div class="row justify-content-center my-3" style="background-color: rgba(211,61,51,1)">
        <h1 class="section_head text-light">
            @lang("Public_ViewEvent.order_details")
        </h1>
    </div>
    <div class="row mb-5">
        <div class="col-md-7 col-lg-8">
            <div class="event_order_form card py-3 px-5">
                {!! Form::open(['url' => route('postCreateOrder', ['event_id' => $event->id]),
                'class' => ($order_requires_payment && @$payment_gateway->is_on_site) ? 'ajax payment-form' : 'ajax', 'data-stripe-pub-key' => isset($account_payment_gateway->config['publishableKey']) ? $account_payment_gateway->config['publishableKey'] : '']) !!}

                {!! Form::hidden('event_id', $event->id) !!}

                <h4> @lang("Public_ViewEvent.your_information")</h4>

                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label("order_first_name", trans("Public_ViewEvent.first_name")) !!}
                            {!! Form::text("order_first_name", old('order_first_name'), ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::label("order_last_name", trans("Public_ViewEvent.last_name")) !!}
                            {!! Form::text("order_last_name", old('order_last_name'), ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label("order_email", trans("Public_ViewEvent.email")) !!}
                            {!! Form::text("order_email", old('order_email'), ['required' => 'required', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="p20 pl0">
                    <a href="javascript:void(0);" class="btn btn-sm" id="mirror_buyer_info" style="background-color: rgba(211,61,51,1); color: #ffffff; padding: 7px 30px; ">
                        @lang("Public_ViewEvent.copy_buyer")
                    </a>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="ticket_holders_details" >
                            <h4>@lang("Public_ViewEvent.ticket_holder_information")</h4>
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
                                        <div class="card-body px-5">
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
                                                @include('Public.ViewEvent.Partials.AttendeeQuestions', ['ticket' => $ticket['ticket'],'attendee_number' => $total_attendee_increment++])

                                            </div>

                                        </div>


                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>

                <style>
                    .offline_payment_toggle {
                        padding: 20px 0;
                    }
                </style>

{{--                @if($order_requires_payment)--}}

{{--                    <h3>@lang("Public_ViewEvent.payment_information")</h3>--}}
{{--                    @lang("Public_ViewEvent.below_payment_information_header")--}}
{{--                    @if($event->enable_offline_payments)--}}
{{--                        <div class="offline_payment_toggle">--}}
{{--                            <div class="custom-checkbox">--}}
{{--                                @if($payment_gateway === false)--}}
{{--                                    --}}{{--  Force offline payment if no gateway  --}}
{{--                                    <input type="hidden" name="pay_offline" value="1">--}}
{{--                                    <input id="pay_offline" type="checkbox" value="1" checked disabled>--}}
{{--                                @else--}}
{{--                                    <input data-toggle="toggle" id="pay_offline" name="pay_offline" type="checkbox" value="1">--}}
{{--                                @endif--}}
{{--                                <label for="pay_offline">@lang("Public_ViewEvent.pay_using_offline_methods")</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="offline_payment" style="display: none;">--}}
{{--                            <h5>@lang("Public_ViewEvent.offline_payment_instructions")</h5>--}}
{{--                            <div class="well">--}}
{{--                                {!! Markdown::parse($event->offline_payment_instructions) !!}--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    @endif--}}


{{--                    @if(@$payment_gateway->is_on_site)--}}
{{--                        <div class="online_payment">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('card-number', trans("Public_ViewEvent.card_number")) !!}--}}
{{--                                        <input required="required" type="text" autocomplete="off" placeholder="**** **** **** ****" class="form-control card-number" size="20" data-stripe="number">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-xs-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('card-expiry-month', trans("Public_ViewEvent.expiry_month")) !!}--}}
{{--                                        {!!  Form::selectRange('card-expiry-month',1,12,null, [--}}
{{--                                                'class' => 'form-control card-expiry-month',--}}
{{--                                                'data-stripe' => 'exp_month'--}}
{{--                                            ] )  !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-xs-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('card-expiry-year', trans("Public_ViewEvent.expiry_year")) !!}--}}
{{--                                        {!!  Form::selectRange('card-expiry-year',date('Y'),date('Y')+10,null, [--}}
{{--                                                'class' => 'form-control card-expiry-year',--}}
{{--                                                'data-stripe' => 'exp_year'--}}
{{--                                            ] )  !!}</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::label('card-expiry-year', trans("Public_ViewEvent.cvc_number")) !!}--}}
{{--                                        <input required="required" placeholder="***" class="form-control card-cvc" data-stripe="cvc">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    @endif--}}

{{--                @endif--}}

                @if($event->pre_order_display_message)
                    <div class="well well-small">
                        {!! nl2br(e($event->pre_order_display_message)) !!}
                    </div>
                @endif

                {!! Form::hidden('is_embedded', $is_embedded) !!}
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::checkbox("order_terms", true, true,['required' => 'required', 'class' => 'form-control','style'=>'width:fit-content;display:inline-block;margin-right:10px']) !!}
                            <a style="color: #000000;" target="_blank" href="{{route('about',['page'=>'oferta_'.Config::get('app.locale')])}}">@lang('ClientSide.terms_conditions')</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::submit(trans("Public_ViewEvent.checkout_submit"), ['class' => 'check-order-btn btn btn-lg btn-danger card-submit','style'=>'float:right']) !!}
                        </div>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-5 col-lg-4">
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
                                <td class="pl0">{{{$ticket['ticket']['title']}}} X <b>{{$ticket['qty']}}</b></td>
                                <td style="text-align: right;">{{money($ticket['total_booking_fee'], $event->currency)}}</td>
                                <td style="text-align: right;">
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
                            @lang("Public_ViewEvent.total"): <span style="float: right;"><b>{{ $orderService->getOrderTotalWithBookingFee(true) }}</b></span>
                        </h5>
                        @if($event->organiser->charge_tax)
                            <h5>
                                {{ $event->organiser->tax_name }} ({{ $event->organiser->tax_value }}%):
                                <span style="float: right;"><b>{{ $orderService->getTaxAmount(true) }}</b></span>
                            </h5>
                            <h5>
                                <strong>@lang("Public_ViewEvent.grand_total")</strong>
                                <span style="float: right;"><b>{{  $orderService->getGrandTotal(true) }}</b></span>
                            </h5>
                        @endif
                    </div>
                @endif

            </div>
            <div class="help-block">
                {!! @trans("Public_ViewEvent.time", ["time"=>"<span id='countdown'></span>"]) !!}
            </div>
        </div>

    </div>
</section>
