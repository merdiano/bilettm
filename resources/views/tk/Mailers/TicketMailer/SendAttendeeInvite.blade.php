@extends('en.Emails.Layouts.Master')

@section('message_content')
Salam {{$attendee->first_name}}!<br><br>

Siz <b>{{$attendee->order->event->title}}</b> çäresine çagyrylýaňyz.<br/>
Siziň çärä gatnaşmak üçin petekleriňiz şu poçta birikdirilen.

<br><br>
Hormatlamak bilen, Biletttm.com topary.
@stop
