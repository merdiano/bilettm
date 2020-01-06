<div class="col-12 p-0">

    <h2 class="main-title" style="padding-left: 5px">{{__("ClientSide.schedule")}}</h2>
    <div class="main-title-bottom-line" style="margin-left: 5px"></div>
    @if($event->end_date->isPast())
        <div class="alert alert-boring">
            @lang("Public_ViewEvent.event_already", ['started' => trans('Public_ViewEvent.event_already_ended')])
        </div>
    @else
        @if(count($ticket_dates) > 0)

        <h4 class="date-small-title">{{__("ClientSide.datePlay")}}</h4>
        <div class="date-box-wrap">
            <ul class="nav nav-pills details-page">

                @foreach($ticket_dates as $date =>$ticket)
                    <li><a class="tablinks" style="cursor: pointer" onclick="openContent(event, '{{$date}}')">{{$date}}</a></li>
                @endforeach

            </ul>

            {{--<a href="" class="active-date">20.07.2019</a>--}}
        </div>
        <h4 class="time-small-title">Билеты</h4>
        <div class="time-box-wraper col-md-6">

                <div class="tab-content" id="myTabContent">
                    @foreach($ticket_dates as $date =>$tickets)
                        <div class="tab-pane fade show active tabcontent" id="{{$date}}" role="tabpanel" aria-labelledby="{{$date}}-tab">
                            <div class="tickets_table_wrap">
                                {!! Form::open(['url' => route('postValidateTickets', ['event_id' => $event->id]), 'class' => 'ajax']) !!}
                                <table class="table">
                                    <?php
                                    $is_free_event = true;
                                    ?>
                                    @foreach($tickets as $ticket)
                                        <tr class="ticket" property="offers" typeof="Offer">
                                            <td>{{$ticket->ticket_date->format('H:i')}}</td>
                                            <td>
                                                <span class="ticket-title semibold" property="name">
                                                    {{$ticket->title}}
                                                </span>
                                                <p class="ticket-descripton mb0 text-muted" property="description">
                                                    {{$ticket->description}}
                                                </p>
                                            </td>
                                            <td style="width:200px; text-align: right;">
                                                <div class="ticket-pricing" style="margin-right: 20px;">
                                                    @if($ticket->is_free)
                                                        @lang("Public_ViewEvent.free")
                                                        <meta property="price" content="0">
                                                    @else
                                                        <?php
                                                        $is_free_event = false;
                                                        ?>
                                                        <span title='{{money($ticket->price, $event->currency)}} @lang("Public_ViewEvent.ticket_price") + {{money($ticket->total_booking_fee, $event->currency)}} @lang("Public_ViewEvent.booking_fees")'>{{money($ticket->total_price, $event->currency)}} </span>
                                                        <span class="tax-amount text-muted text-smaller">{{ ($event->organiser->tax_name && $event->organiser->tax_value) ? '(+'.money(($ticket->total_price*($event->organiser->tax_value)/100), $event->currency).' '.$event->organiser->tax_name.')' : '' }}</span>
                                                        <meta property="priceCurrency"
                                                              content="TMT">
                                                        <meta property="price"
                                                              content="{{ number_format($ticket->price, 2, '.', 'TMT') }}">
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="width:85px;">
                                                @if($ticket->is_paused)

                                                    <span class="text-danger">@lang("Public_ViewEvent.currently_not_on_sale")</span>
                                                @else

                                                    @if($ticket->sale_status === config('attendize.ticket_status_sold_out'))
                                                        <span class="text-danger" property="availability"
                                                              content="http://schema.org/SoldOut">@lang("Public_ViewEvent.sold_out")</span>
                                                    @elseif($ticket->sale_status === config('attendize.ticket_status_before_sale_date'))
                                                        <span class="text-danger">@lang("Public_ViewEvent.sales_have_not_started")</span>
                                                    @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                                        <span class="text-danger">@lang("Public_ViewEvent.sales_have_ended")</span>
                                                    @else
                                                        {!! Form::hidden('tickets[]', $ticket->id) !!}
                                                        <meta property="availability" content="http://schema.org/InStock">
                                                        <select name="ticket_{{$ticket->id}}" class="form-control"
                                                                style="text-align: center">
                                                            @if (count($tickets) > 1)
                                                                <option value="0">0</option>
                                                            @endif
                                                            @for($i=$ticket->min_per_person; $i<=$ticket->max_per_person; $i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    @endif

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="4" style="text-align: center">
                                            @lang("Public_ViewEvent.below_tickets")
                                        </td>
                                    </tr>
                                    <tr class="checkout">
                                        <td colspan="4">
                                            @if(!$is_free_event)
                                                <div class="hidden-xs pull-left">
                                                    @if($event->enable_offline_payments)

                                                        <div class="help-block" style="font-size: 11px;">
                                                            @lang("Public_ViewEvent.offline_payment_methods_available")
                                                        </div>
                                                    @endif
                                                </div>

                                            @endif
                                            {!!Form::submit(trans("Public_ViewEvent.register"), ['class' => 'btn btn-lg btn-primary pull-right'])!!}
                                        </td>
                                    </tr>
                                </table>
                                {!! Form::hidden('is_embedded', $is_embedded) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
        @else

                <div class="alert alert-boring">
                    @lang("Public_ViewEvent.tickets_are_currently_unavailable")
                </div>
        @endif
    @endif
</div>

@push('after_scripts')
    <script>
        function openContent(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
@endpush