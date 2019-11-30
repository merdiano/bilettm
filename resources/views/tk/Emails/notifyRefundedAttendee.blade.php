@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>Salam!</p>
    <p>
        Siz <b>{{{$attendee->event->title}}} çäresine alan petegiňize yzyna tabşyrmak boýunça harçlanan pul serişdeleriňiz yzyna geçirildi</b>.
        <b>{{{ $refund_amount }}} möçberindäki pul serişdeleri satyn alyja gaýtarylyp berildi, siz gaýtarylan pulyňyzy birnäçe günüň içinde yzyna alyp bilersiňiz.</b>
    </p>

    <p>
        <b>{{{ $attendee->event->organiser->name }}}</b> bilen habarlaşmak üçin <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> ýazyň ýa-da şu poçta hem jogap berip bilersiňiz.
    </p>
@stop

@section('footer')

@stop