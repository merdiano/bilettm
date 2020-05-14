@extends('Emails.Layouts.Master')
@section('message_content')
    <p><strong>Здравствуйте!</strong></p>
    <p>
        My poluchili wash zapros <a href="{{route('help.show',['code' => $ticket->code])}}"> No:{{ $ticket->code }}.</a> Ozhidayte uvedomlenie ob otwete.
    </p>

    <p>
        S uwazheniem, sluzhba podderzhki klientow
    </p>

    <div style="margin-top: 10px; background-color:  #ccc;">
        <p><strong>Salam!</strong></p>
        <p>
            My poluchili wash zapros <a href="{{route('help.show',['code' => $ticket->code])}}"> No:{{ $ticket->code }}.</a> Ozhidayte uvedomlenie ob otwete.
        </p>
        <p>
            Hormatlamak bilen, tehpodderzhka
        </p>
    </div>


@endsection

@section('footer')


@stop
