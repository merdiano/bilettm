<div class="row">
    <div class="col-12">
        <h3 class="my-4" >{{__('ClientSide.step')}} 2. {{__('ClientSide.choose_sector')}}</h3>
        <div class="pills-struct mt-1">
            <ul role="tablist" class="nav nav-pills m-auto w-auto justify-content-center" id="choose_seats">
                @foreach($venue->sectors->sortBy('order') as $sector)
                    <li role="presentation" class="d-inline-block mb-4">
                        <a aria-expanded="true" data-toggle="tab" class="btn btn-lg px-5 show @if(!$sector->hasTickets($tickets)) disabled @endif"
                           role="tab" id="home_tab_{{$sector->id}}" href="#home_{{$sector->id}}" aria-selected="true">
                            {{$sector->title}}

                        </a>
                    </li>
                @endforeach
            </ul>

            <h3 class="pt-5 my-4" >{{__('ClientSide.step')}} 3. {{__('ClientSide.choose_seat')}}</h3>
            <div class="mt-2 mb-4">
                <span class="pr-4"><i class="fa fa-circle" style="color: #ebeced; font-size: 13px"></i> {{__('ClientSide.available')}}</span>
                <span class="pr-4"><i class="fa fa-circle" style="color: #06b84d; font-size: 13px"></i> {{__('ClientSide.booked')}}</span>
                <span class="pr-4"><i class="fa fa-circle" style="color: #4e5ced; font-size: 13px"></i> {{__('ClientSide.reserved')}}</span>
                <span class="pr-4"><i class="fa fa-circle" style="color: #ff4159; font-size: 13px"></i> {{__('ClientSide.selection')}}</span>
            </div>
            <form class="tab-content ajax" id="seats-form" action="{{route('postValidateTickets',['event_id'=>$event->id])}}" method="post">
                @csrf
                @foreach($venue->sectors->sortBy('order')  as $sector)
                    @if($sector->hasTickets($tickets))
                        <div id="home_{{$sector->id}}" class="tab-pane fade in" role="tabpanel">
                            @foreach($sector->filterTickets($tickets) as $ticket)
                                <h4  class="font-weight-bold pt-4">{{__("ClientSide.category")}} : {{$ticket->section->section_no}} ( {{$ticket->price}} TMT.)<small> {{$ticket->section->description}}</small>
                                </h4>
                                <meta property="priceCurrency"
                                      content="TMT">
                                <meta property="price"
                                      content="{{ number_format($ticket->price, 2, '.', '') }}">
                                @if($ticket->is_paused)
                                    <div class="alert alert-warning" role="alert">@lang("Public_ViewEvent.currently_not_on_sale")</div>
                                @elseif($ticket->sale_status === config('attendize.ticket_status_after_sale_date'))
                                    <div class="alert alert-warning" role="alert">@lang("Public_ViewEvent.sales_have_ended")</div>
                                @else
                                    <meta property="availability" content="http://schema.org/InStock">
                                    @if($ticket->section->seats)
                                        <div style="overflow-x: auto; white-space: nowrap; max-width: 100%;">
                                            <table data-id="{{$sector->id.'-'.$ticket->id}}"
                                                   class="w-100"
                                                   style="table-layout: fixed;"
                                                   data-content='{!! zanitlananlar($ticket)!!}'>
                                                <tbody  data-num="{{$ticket->price}}" data-max="{{$ticket->max_per_person}}" >
                                                @foreach($ticket->section->seats as $row)
                                                    <tr>
                                                        <td class="g-width-50">{{$row['row']}} {{__('ClientSide.row')}}</td>

                                                        @for($i = $row['start_no'];$i<=$row['end_no'];$i++)
                                                            <td style="position: relative; display: inline-block; margin: 15px !important">
                                                                <input type="checkbox" class="seat_check"
                                                                       id="seat{{$sector->id.'-'.$ticket->id.'-'.$row['row'].'-'.$i}}"
                                                                       name="seats[{{$ticket->id}}][]"
                                                                       value="{{$row['row'].'-'.$i}}">
                                                                <label for="seat{{$sector->id.'-'.$ticket->id.'-'.$row['row'].'-'.$i}}">
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
                                        </div>

                                        @if($ticket->totalbookingFee)
                                            <p class="my-3">* @lang('ClientSide.booking_fee_text') {{money($ticket->totalbookingFee)}}</p>
                                        @endif
                                    @endif
                                @endif

                            @endforeach
                        </div>
                    @endif
                @endforeach
                <h5 class="mt-5">{{__("ClientSide.yourSeats")}}:</h5>
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
             //console.warn(disable_list);
            var table_id = $(table).data('id');
            //console.warn(table_id);
            for(var i=0; i<disable_list.length; i++){

                var objkey = Object.keys(disable_list[i]);
                 //console.warn(objkey);
                var obValue = Object.values(disable_list[i])
                 //console.warn($('#seat'+table_id+'-'+objkey).val());
                $('#seat'+table_id+'-'+objkey).addClass('input-'+obValue);
                $('#seat'+table_id+'-'+objkey).attr("disabled", true);
            }
        }

    </script>

@endsection