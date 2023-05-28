<div class="row">
    <div class="col-12">
        <h2 class="pt-5 my-4" >{{__('ClientSide.step')}} 2. {{__('ClientSide.choose_sector')}}</h2>
        <div class="pills-struct mt-5">
            <ul role="tablist" class="nav nav-pills m-auto w-auto justify-content-center" id="choose_seats">
                @foreach($tickets as $ticket)
                    <li class="active" role="presentation" style="display: inline-block;">
                        <a aria-expanded="true" data-toggle="tab" class="btn btn-lg @if ($loop->first)active @endif show"
                           role="tab" id="home_tab_{{$ticket->id}}" href="#home_{{$ticket->id}}" aria-selected="true">
                            {{$ticket->title}} - {{$ticket->price}} TMT.

                        </a>
                    </li>
                @endforeach
            </ul>

            <h2 class="pt-5 my-4" >{{__('ClientSide.step')}} 3. {{__('ClientSide.choose_seat')}}</h2>
            <div class="mt-2 mb-4">
                <span class="pr-5"><i class="fa fa-circle" style="color: #ebeced; font-size: 13px"></i> {{__('ClientSide.available')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #06b84d; font-size: 13px"></i> {{__('ClientSide.booked')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #4e5ced; font-size: 13px"></i> {{__('ClientSide.reserved')}}</span>
                <span class="pr-5"><i class="fa fa-circle" style="color: #ff4159; font-size: 13px"></i> {{__('ClientSide.selection')}}</span>
            </div>
            <!-- Button trigger modal -->


            <!-- Modal -->
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
            <form id="seats-form" class="ajax" action="{{route('postValidateTickets',['event_id'=>$event->id])}}" method="post">
                @csrf
                <div class="tab-content" id="choose_seats_content">
                    @foreach($tickets as $ticket)
                        <div id="home_{{$ticket->id}}" class="tab-pane fade in @if ($loop->first) active show @endif " role="tabpanel">
                            <meta property="priceCurrency"
                                  content="TMT">
                            <meta property="price"
                                  content="{{ number_format($ticket->price, 2, '.', '') }}">
                            {{--<div class="row justify-content-center">--}}
                            {{--<img style="max-width: 60%;" class="img-responsive" alt="{{$event->venue->venue_name}} - {{$ticket->section->section_no}}"--}}
                            {{--src="{{asset('user_content/'.$ticket->section->section_image)}}" >--}}
                            {{--</div>--}}
                            @if($ticket->is_paused)
                                <h5 class="text-danger text-center">@lang("Public_ViewEvent.currently_not_on_sale")</h5>
                            @else
                                @if($ticket->sale_status === config('attendize.ticket_status_sold_out'))
                                    <h5 class="text-danger " property="availability"content="http://schema.org/SoldOut">
                                        @lang("Public_ViewEvent.sold_out")
                                    </h5>
                                @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                    <h4 class="text-danger ">@lang("Public_ViewEvent.sales_have_ended")</h4>5
                                @else
                                    <meta property="availability" content="http://schema.org/InStock">
                                    <div class="standard-box">
                                        <h5  class="font-weight-bold">{{$ticket->section->section_no}}  <small>{{$ticket->section->description}}</small></h5>

                                        @if($ticket->section->seats)
                                            <table data-id="{{$ticket->id}}"
                                                   data-content='{!! zanitlananlar($ticket)!!}'>
                                                <tbody  data-num="{{$ticket->price}}" data-max="{{$ticket->max_per_person}}" >
                                                @foreach($ticket->section->seats as $row)
                                                    <tr>
                                                        <td>{{$row['row']}}</td>
                                                        <td></td>
                                                        <td></td>
                                                        @for($i = $row['start_no'];$i<=$row['end_no'];$i++)
                                                            <td style="position: relative; display: inline-block; margin: 15px !important">
                                                                <input type="checkbox" class="seat_check"
                                                                       id="seat{{$ticket->id.'-'.$row['row'].'-'.$i}}"
                                                                       name="seats[{{$ticket->id}}][]"
                                                                       value="{{$row['row'].'-'.$i}}">
                                                                <label for="seat{{$ticket->id.'-'.$row['row'].'-'.$i}}">
                                                                    <svg style="position: absolute; top: 0; left: 0;" xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25">
                                                                        <path id="Rectangle_3" data-name="Rectangle 3" d="M8,0H18a8,8,0,0,1,8,8V25a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V8A8,8,0,0,1,8,0Z"></path>
                                                                    </svg>
                                                                    <span style="position:absolute;left: 7px;top: 1px;">{{$i}}</span>
                                                                </label>
                                                            </td>
                                                        @endfor
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>

                                @endif
                            @endif

                        </div>
                        @if($ticket->totalbookingFee)
                            <h5 class="my-3">* @lang('ClientSide.booking_fee_text') {{money($ticket->totalbookingFee)}}</h5>
                        @endif
                    @endforeach
                </div>
                <h5>{{__("ClientSide.yourSeats")}}:</h5>
                <div id="your-selected-seats" class="mb-5 row p-3">
                </div>
                {!!Form::submit(trans("ClientSide.confirm-seats"), ['id' => 'confirm-seats','class'=>'btn btn-danger btn-lg'])!!}
            </form>
        </div>
    </div>
</div>
@section('after_scripts')
    <script>
        $(':checkbox').change(function() {
            var table = $(this).closest('tbody');
            var max_seats = table.data('max');
            var checkedCount = table.find('input:checkbox:checked').length;

            if(checkedCount>max_seats){
                $(this).prop("checked",false)
                showMessage("@lang('ClientSide.exceeds')"+max_seats)
                return;
            }

            if(this.checked) {
                var ticket = "<span aria-label='"+this.id+"'>"+this.value+"</span>"
                $('#your-selected-seats').append(ticket);

            }
            else{
                $('#your-selected-seats').find("[aria-label='"+this.id+"']").remove();
            }

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

@endsection