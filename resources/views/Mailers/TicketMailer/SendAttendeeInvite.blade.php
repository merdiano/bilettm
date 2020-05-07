@extends('ru.Emails.Layouts.Master')

@section('message_content')
    Здравствуйте {{$attendee->first_name}},<br><br>

    Вы были приглашены на мероприятие <b>{{$attendee->order->event->title}}</b>.<br/>
    Ваш билет на мероприятие прилагается к этому письму.

<br><br>
С уважением!
@stop
