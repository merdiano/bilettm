@extends('Emails.Layouts.Master')
@section('message_content')
    <p><strong>Здравствуйте!</strong></p>
    <p>
        Получен ответ на Вашу заявку №: {{ $comment->ticket->code }}.
    </p>
    <p>Чтобы просмотреть текст, перейдите по <a href="{{route('help.show',['code' => $comment->ticket->code])}}">ссылке</a></p>

    <p>
        С уважением, служба поддержки клиентов.
    </p>

    <div style="margin-top: 10px; background-color:  #ccc;">
        <p><strong>Salam!</strong></p>
        <p>
            Siziň №: {{ $ticket->code }} belgili hatyňyza jogap ýazyldy.
        </p>
        <p>Jogaby görmek üçin <a href="{{route('help.show',['code' => $comment->ticket->code])}}">şu ýere</a> basyň!</p>
        <p>
            Hormatlamak bilen, teh. goldaw.
        </p>
    </div>


@endsection

@section('footer')


@stop
