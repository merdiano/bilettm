@extends('en.Emails.Layouts.Master')

@section('message_content')
    Здравствуйте {{$attendee->first_name}},<br><br>

    Ваш билет на мероприятие <b>{{$attendee->order->event->title}}</b> прикреплен к этому письму.

<br><br>
Thank you
@stop
