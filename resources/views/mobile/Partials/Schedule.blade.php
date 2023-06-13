@if(count($ticket_dates) > 0)
    {{--<h2 class="main-title" style="padding-left: 5px">Расписание</h2>--}}
    {{--<div class="main-title-bottom-line" style="margin-left: 5px"></div>--}}
    @if($event->end_date->isPast())
    <div class="alert alert-boring">
        <h4 class="date-small-title">
            @lang("Public_ViewEvent.event_already", ['started' => trans('Public_ViewEvent.event_already_ended')])
        </h4>
    </div>
    @else
        <h4 class="date-small-title mt-3" >@lang('ClientSide.event_dates')</h4>
        <div class="date-box-wrap">
            <ul class="nav nav-pills details-page">

                @foreach($ticket_dates as $date =>$ticket)

                    <li><a class="tablinks @if ($loop->first)active @endif" style="cursor: pointer" onclick="openContent(event, '{{$date}}')">{{$date}}</a></li>
                @endforeach

            </ul>
        </div>
        <h4 class="time-small-title">@lang('ClientSide.event_times')</h4>
        <div class="time-box-wraper col-md-6" style="padding-left: 5px">

            <div class="tab-content" id="myTabContent">
                {!! Form::open(['url' => route('postValidateDate', ['event_id' => $event->id]),'method'=>'GET']) !!}
                @foreach($ticket_dates as $date =>$tickets)
                    <div class="tab-pane fade show tabcontent @if ($loop->first)active @endif" id="{{$date}}" role="tabpanel" aria-labelledby="{{$date}}-tab">
                        <div class="time-box-wrap">

                                @foreach($tickets as $ticket)
                                <div class="form-group">
                                    <input type="radio" id="time{{$loop->index}}" @if ($loop->first)checked @endif name="ticket_date" value="{{$ticket->format('H:i')}}">
                                    <label for="time{{$loop->index}}"><span>{{$ticket->format('H:i')}}</span></label>
                                </div>
                                @endforeach
                        </div>
                    </div>
                @endforeach
                {!!Form::submit(trans('ClientSide.buy_ticket'), ['class' => 'btn btn-lg btn-danger'])!!}
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@endif
@push('after_scripts')
    <script>

        $(document).ready(function(){
            $(".nav-pills.details-page .tablinks:first-child").click();
        });

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

        var tablinks = document.getElementsByClassName("tablinks");
        tablinks[0].className += " active";

        $(document).ready(function () {
            $(".time-box-wrap input[type=radio]").css('display', 'none');
            $(".time-box-wrap input[type=radio]:checked").css('background-image', '');
            $("input.btn-danger").css('background-color', '#d43d34');
            $("input.btn-danger").css('margin-top', '20px');
        });

    </script>
@endpush
