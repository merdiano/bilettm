@extends('Emails.Layouts.Master')

@section('message_content')

<p>Добрый день,</p>
<p>
    Ваш билет на мероприятие <b>{{{$attendee->event->title}}}</b> был отменен.
</p>

<p>
    Вы можете связаться с <b>{{{$attendee->event->organiser->name}}}</b> по электронному адресу <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> или ответив на это письмо, если вам потребуется дополнительная информация.
</p>
@stop

@section('footer')

@stop
