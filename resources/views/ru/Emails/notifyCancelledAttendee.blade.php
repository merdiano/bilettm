@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Всем привет,</p>
<p>
    Ваш билет на мероприятие <b>{{{$attendee->event->title}}}</b> был отменен.
</p>

<p>
    Вы можете связаться с <b>{{{$attendee->event->organiser->name}}}</b> прямо на <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> или ответив на это письмо, если вам потребуется дополнительная информация.
</p>
@stop

@section('footer')

@stop
