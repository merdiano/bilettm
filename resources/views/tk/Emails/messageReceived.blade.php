@extends('tk.Emails.Layouts.Master')

@section('message_content')

<p>Salam!</p>
<p>Siz <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> şu poçtany <b>{{ $event->title }}</b> çäre bilen baglanşykly hatyny aldyňyz.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    Siz <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> bilen
    gönümel şu linkde <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>, ýa-da şu poçta jogap berip habarlaşyp bilersiňiz.
</p>
@stop

@section('footer')


@stop
