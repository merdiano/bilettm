@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Всем привет,</p>
<p>Вы получили сообщение от <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> in relation to the event <b>{{ $event->title }}</b>.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    Вы можете связаться <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> прямо на <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>, или ответив на это письмо.
</p>
@stop

@section('footer')


@stop
