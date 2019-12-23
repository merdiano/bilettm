@extends('Bilettm.Layouts.BilettmLayout')
@section('content')
    {{\DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render('seats',$event)}}
    <section style="margin-bottom: 80px">
        <div class="container">
            <a class="mobile_pt_30 mobile_pb0 collapsed d-flex justify-content-between g-color-main g-text-underline--none--hover g-brd-bottom g-brd-gray-light-v4 g-pa-15-0" href="#accordion-10-body-02" data-toggle="collapse" data-parent="#accordion-10" aria-expanded="false" aria-controls="accordion-10-body-02">
                <span class="d-flex">
                    <h1 class="mobile_header_tab" style="font-weight: 600;font-size: 35px;">{{__('ClientSide.seats')}}</h1>
                </span>
            </a>
            <div class="row">
                <div class="col-md-12">
                    <div class="pills-struct mt-5">
                        @if($tickets->count()>1)
                        <ul role="tablist" class="nav nav-pills m-auto w-auto justify-content-center" id="choose_seats">
                            @foreach($tickets as $ticket)
                                <li class="active" role="presentation" style="display: inline-block;">
                                    <a aria-expanded="true" data-toggle="tab" class="@if ($loop->first)active @endif show"
                                       role="tab" id="home_tab_{{$ticket->id}}" href="#home_{{$ticket->id}}" aria-selected="true">
                                        {{$ticket->title}} - {{$ticket->total_price}} TMT.

                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="d-flex mt-5 mb-4" style="width: fit-content; margin: auto">
                            <span class="text-center" style="width: fit-content; margin: 0 15px; font-size: 18px"><i class="fa fa-circle" style="color: #ebeced; font-size: 13px"></i> {{__('ClientSide.available')}}</span>
                            <span class="text-center" style="width: fit-content; margin: 0 15px; font-size: 18px"><i class="fa fa-circle" style="color: #69687d; font-size: 13px"></i> {{__('ClientSide.booked')}}</span>
                            <span class="text-center" style="width: fit-content; margin: 0 15px; font-size: 18px"><i class="fa fa-circle" style="color: #b6b6b6; font-size: 13px"></i> {{__('ClientSide.reserved')}}</span>
                            <span class="text-center" style="width: fit-content; margin: 0 15px; font-size: 18px"><i class="fa fa-circle" style="color: #ff4159; font-size: 13px"></i> {{__('ClientSide.selection')}}</span>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary seats-map" data-toggle="modal" data-target="#exampleModal"
                                style="background-color: #ffffff; color: #d43d34; border: 1px solid #d43d34; display: block; margin: auto; margin-bottom: 20px; padding: 10px 50px">
                            Seats map
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="background-color: unset; border: none; ">
                                    <div class="modal-header" style="border-bottom: none">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                                style="border: 2px solid #ffffff; border-radius: 100px; padding: 0; opacity: 1">
                                            <span aria-hidden="true"
                                                  style="color: #ffffff; opacity: 1; text-shadow: none; font-weight: lighter; font-size: 35px; padding: 0px !important; width: 30px; height: 30px; display: block; line-height: 31px;">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="img-responsive" src="{{asset('user_content/'.$event->venue->seats_image)}}" width="800">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form id="seats-form" class="ajax" action="{{route('postValidateTickets',['event_id'=>$event->id])}}" method="post">
                            @csrf
                        <div class="tab-content" id="choose_seats_content">
                            @foreach($tickets as $ticket)
                                <div id="home_{{$ticket->id}}" class="tab-pane fade active show in " role="tabpanel">
                                    <meta property="priceCurrency"
                                          content="TMT">
                                    <meta property="price"
                                          content="{{ number_format($ticket->price, 2, '.', '') }}">
                                    {{--<div class="row justify-content-center">--}}
                                        {{--<img style="max-width: 60%;" class="img-responsive" alt="{{$event->venue->venue_name}} - {{$ticket->section->section_no}}"--}}
                                             {{--src="{{asset('user_content/'.$ticket->section->section_image)}}" >--}}
                                    {{--</div>--}}
                                    @if($ticket->is_paused)
                                        <h1 class="text-danger">@lang("Public_ViewEvent.currently_not_on_sale")</h1>
                                    @else
                                        @if($ticket->sale_status === config('attendize.ticket_status_sold_out'))
                                            <span class="text-danger" property="availability"content="http://schema.org/SoldOut">
                                                @lang("Public_ViewEvent.sold_out")
                                            </span>
                                        @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                            <span class="text-danger">@lang("Public_ViewEvent.sales_have_ended")</span>
                                        @else
                                            <meta property="availability" content="http://schema.org/InStock">
                                            <div class="standard-box" style="position: relative; padding: 20px 0">
                                                <h5 style="font-size: 24px;" class="text-center font-weight-bold">{{$ticket->section->section_no}}  <small>@lang('Public_ViewEvent.price') {{$ticket->total_price}} TMT.</small></h5>
                                                <h4 class="text-center mt-3 mb-5">{{$ticket->section->description}}</h4>
                                                <table data-id="{{$ticket->id}}" style="text-align: center; margin: auto"
                                                       data-content='{!! zanitlananlar($ticket)!!}'>
                                                    <tbody  data-num="{{$ticket->price}}" data-max="{{$ticket->max_per_person}}">
                                                    @foreach($ticket->section->seats as $row)
                                                        <tr>
                                                            <td>{{$row['row']}}</td>
                                                            <td></td>
                                                            <td></td>
                                                            @for($i = $row['start_no'];$i<=$row['end_no'];$i++)
                                                                <td>
                                                                    <input type="checkbox" class="seat_check"
                                                                           id="seat{{$ticket->id.'-'.$row['row'].'-'.$i}}"
                                                                           name="seats[{{$ticket->id}}][]"
                                                                           value="{{$row['row'].'-'.$i}}">
                                                                    <label for="seat{{$ticket->id.'-'.$row['row'].'-'.$i}}">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25">
                                                                            <path id="Rectangle_3" data-name="Rectangle 3" d="M8,0H18a8,8,0,0,1,8,8V25a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V8A8,8,0,0,1,8,0Z"></path>
                                                                        </svg>
                                                                        <span style="position:relative;right: 55%">{{$i}}</span>
                                                                    </label>
                                                                </td>
                                                            @endfor
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody></table>
                                                <!--<div class="seats-top-overlay" style="width: 70%"></div>-->
                                            </div>

                                        @endif
                                    @endif

                                </div>
                            @endforeach
                        </div>
                        <div class="checked-seats" style="padding: 50px 0; text-align: center">
                            <h5 class="text-center font-weight-bold">{{__("ClientSide.selected")}} <span id="total_seats">0</span> {{__("ClientSide.seatsTotal")}} <span id="total_cost">0</span> man.</h5>
                            <h5 class="text-center">{{__("ClientSide.yourSeats")}}:</h5>
                                <div class="your-selected-seats" style="text-align: center; margin-bottom: 50px">
                                </div>
                            {!!Form::submit('Confirm seats', ['id' => 'confirm-seats'])!!}
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@section('after_scripts')
    <script>
        $(':checkbox').change(function() {
            var table = $(this).closest('tbody');
            var max_seats = table.data('max');
            var checkedCount = table.find('input:checkbox:checked').length;

            if(checkedCount>max_seats){
                $(this).prop("checked",false)
                showMessage("You have excidid maximum ticket count: "+max_seats)
                return;
            }

            if(this.checked) {
                var ticket = "<span aria-label='"+this.id+"'>"+this.value+"</span>"
               $('.your-selected-seats').append(ticket);

            }
            else{
                $('.your-selected-seats').find("[aria-label='"+this.id+"']").remove();
            }

            var total_cost = 0;
            var numberOfChecked = $('input:checkbox:checked').length;
            $('input:checkbox:checked').each(function(index, elem) {
                total_cost += parseFloat($(elem).closest('tbody').data('num'));

            });
            $('#total_seats').html(numberOfChecked);
            $('#total_cost').html(total_cost.toFixed(2));
        });

        $(document).ready(function () {
            $('table').each(function (index,table) {
                disable_rb(table);
            });
        });
        function disable_rb(table) {
            //alert(reserved[0]);
            var disable_list = $(table).data('content');
            // console.warn(JSON.parse(disable_list));
            var table_id = $(table).data('id');
            for(var i=0; i<disable_list.length; i++){

                var objkey = Object.keys(disable_list[i]);
                // console.warn(objkey);
                var obValue = Object.values(disable_list[i])
                 // console.log($('#seat'+table_id+'-'+objkey).val());
                $('#seat'+table_id+'-'+objkey).addClass('input-'+obValue);
                $('#seat'+table_id+'-'+objkey).attr("disabled", true);
            }
        }

    </script>
    @include("Shared.Partials.LangScript")
    {!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}
@endsection
