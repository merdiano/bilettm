@extends('Emails.Layouts.Master')
@section('message_content')
    <p><strong>Здравствуйте!</strong></p>
    <p>
        Мы получили ваш запрос <a href="{{route('help.show',['code' => $ticket->code])}}"> c:{{ $ticket->code }}.</a> Ожидайте уведомление об ответе.
    </p>

    <p>
        С уважением, служба поддержки клиентов.
    </p>

    <div style="margin-top: 10px; background-color:  #ccc;">
        <p><strong>Salam!</strong></p>
        <p>
            <a href="{{route('help.show',['code' => $ticket->code])}}"> №:{{ $ticket->code }}.</a> belgili hatyňyz bize gowuşdy. Jogabay barada bildiriş hatyna garaşyň.
        </p>
        <p>
            Hormatlamak bilen, teh. goldaw.
        </p>
    </div>


@endsection

@section('footer')


@stop
