@extends('en.Emails.Layouts.Master')

@section('message_content')
Salam {{$attendee->first_name}}!<br><br>

Siziň <b>{{$attendee->order->event->title}}</b> çäre üçin petegiňiz şu poçta birikdirilen.

<br><br>
Sag boluň!
@stop
