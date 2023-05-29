<section id='order_form' class="container">
    <h3 class="my-5">{{__('ClientSide.step')}} 4. {{__('ClientSide.buyer_info_text')}}</h3>

    {!! Form::open(['url' => route('postCreateOrder', ['event_id' => $event->id]),
  'class' => ($order_requires_payment && @$payment_gateway->is_on_site) ? 'ajax payment-form' : 'ajax', 'data-stripe-pub-key' => isset($account_payment_gateway->config['publishableKey']) ? $account_payment_gateway->config['publishableKey'] : '']) !!}
    {!! Form::hidden('event_id', $event->id) !!}

    <div class="form-row">
        <div class="col-12 col-lg-6">
            <div class="form-group">
                {!! Form::label("order_first_name", trans("Public_ViewEvent.first_name")) !!}
                {!! Form::text("order_first_name", old('order_first_name'), ['required' => 'required', 'class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    <div class="form-row">
        <div class="col-12 col-lg-6">
            <div class="form-group">
                {!! Form::label("order_last_name", trans("Public_ViewEvent.last_name")) !!}
                {!! Form::text("order_last_name", old('order_last_name'), ['required' => 'required', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12 col-lg-6">
            <div class="form-group">
                {!! Form::label("order_email", trans("Public_ViewEvent.email")) !!}
                {!! Form::text("order_email", old('order_email'), ['required' => 'required', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>


    @if($event->pre_order_display_message)
        <div class="well well-small">
            {!! nl2br(e($event->pre_order_display_message)) !!}
        </div>
    @endif

    {!! Form::hidden('is_embedded', $is_embedded) !!}
    <div class="form-row">
        <div class="col-6">
            <div class="form-group">
                {!! Form::checkbox("order_terms", true, false,['required' => 'required', 'class' => 'form-control','style'=>'width:fit-content;display:inline-block;margin-right:10px']) !!}
                <a style="color: #000000;" target="_blank" href="{{route('about',['page'=>'oferta_'.Config::get('app.locale')])}}">@lang('ClientSide.terms_conditions')</a>
            </div>
        </div>

    </div>
    <h3 class="my-5">{{__('ClientSide.step')}} 5. {{__('ClientSide.choose_payment_method')}}</h3>
    <div class="form-row mt-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="exampleRadios1" value="halk" required>
            <label class="form-check-label" for="exampleRadios1">
                Altyn Asyr (Halkbank)
            </label>
        </div>


    </div>
    <div class="form-row mt-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="exampleRadios2" value="rysgal">
            <label class="form-check-label" for="exampleRadios2">
                Maestro (Rysgalbank)
            </label>
        </div>
    </div>
    <div class="form-row my-3">
        <div class="form-check disabled">
            <input class="form-check-input" type="radio" name="payment" id="exampleRadios3" value="vneshka">
            <label class="form-check-label" for="exampleRadios3">
                Milli Kart (Türkmenistanyň döwlet daşary ykdysady iş banky)
            </label>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-12 col-lg-6">
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
                            <th style="text-align: right;">@lang('Public_ViewEvent.price')</th>
                            {{--                            <th style="text-align: right;">@lang('Public_ViewEvent.booking_fees')</th>--}}
                            <th style="text-align: right;">@lang('Public_ViewEvent.sub_total')</th>
                        </tr>
                        </thead>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td class="pl0">{{{$ticket['ticket']['title']}}} X <b>{{$ticket['qty']}}</b></td>
                                <td style="text-align: right;">
                                    @if((int)ceil($ticket['original_price']) === 0)
                                        @lang("Public_ViewEvent.free")
                                    @else
                                        {{ money($ticket['original_price'], $event->currency) }}
                                    @endif
                                </td>
                                {{--                                <td style="text-align: right;">{{money($ticket['total_booking_fee'], $event->currency)}}</td>--}}
                                <td style="text-align: right;">{{money($ticket['price'], $event->currency)}}</td>
                            </tr>
                        @endforeach
                        @if($orderService->totalBookingFee)
                            <tr>
                                <td colspan="2">
                                    @lang('Public_ViewEvent.booking_fees')
                                </td>

                                <td style="text-align: right;">{{$orderService->getTotalBookingFee(true)}}</td>
                            </tr>
                        @endif
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
    <div class="form-row">
        <div class="col-12 col-lg-6">
            {!! Form::submit(trans("Public_ViewEvent.checkout_submit"), ['class' => 'btn btn-lg btn-outline-dark card-submit w-100']) !!}
        </div>
    </div>

    {!! Form::close() !!}
</section>
