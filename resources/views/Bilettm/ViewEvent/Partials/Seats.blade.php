@foreach($tickets as $ticket)
    <div id="home_{{$ticket->id}}" class="tab-pane fade active show in" role="tabpanel" style="display: unset !important;">
        <div class="row justify-content-center">
            <img class="img-responsive" src="{{asset('user_content/'.$ticket->section->section_image)}}" alt="{{$ticket->section->section_no}}">
        </div>
    <div class="standard-box" style="position: relative; padding: 20px 0">
        <h5 style="font-weight: bold; font-size: 24px; margin-bottom: 20px; text-align: center">{{$ticket->title }} {{$ticket->description}} {{$ticket->section->section_no}}</h5>
        <table style="text-align: center; margin: auto">
            <tbody>
            @foreach($ticket->section->seats as $row)
            <tr>
                <td>{{$row['row']}}</td>
                <td></td>
                <td></td>
                @for($i = $row['start_no'];$i<=$row['end_no'];$i++)
                <td>
                    <input type="checkbox" id="seata25" name="seata25" class="seat_check">
                    <label for="seata{{$i}}">
                        {{$i}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25">
                            <path id="Rectangle_3" data-name="Rectangle 3" d="M8,0H18a8,8,0,0,1,8,8V25a0,0,0,0,1,0,0H0a0,0,0,0,1,0,0V8A8,8,0,0,1,8,0Z"></path>
                        </svg>
                    </label>
                </td>
                @endfor
                <td></td>
            </tr>
            @endforeach
            </tbody></table>
        <div class="seats-top-overlay" style="width: 70%"></div>
    </div>
</div>
@endforeach
