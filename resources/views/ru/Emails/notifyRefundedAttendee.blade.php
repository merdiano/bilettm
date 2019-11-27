@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>Всем привет,</p>
    <p>
        Вы получили возврат от имени вашего аннулированного билета за <b>{{{$attendee->event->title}}}</b>.
        <b>Чтобы сумма билетов: {{{ $refund_amount }}} была возвращена первоначальному получателю, вы должны увидеть платеж в течение нескольких дней.</b>
    </p>

    <p>
        Вы можете связаться с <b>{{{ $attendee->event->organiser->name }}}</b> прямо на <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> или ответив на это письмо, если вам потребуется дополнительная информация.
    </p>
@stop

@section('footer')

@stop