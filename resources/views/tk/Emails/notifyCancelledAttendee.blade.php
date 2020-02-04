@extends('tk.Emails.Layouts.Master')

@section('message_content')

<p>Salam!</p>
<p>
    Siziň <b>{{{$attendee->event->title}}} çäresi üçin petegiňiz </b> ýatyryldy.
</p>

<p>
     <b>{{{$attendee->event->organiser->name}}}</b> bilen habarlaşmak üçin şu poçta boýunça <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> ýa-da şu hata jogap berip bilersiňiz.
</p>
@stop

@section('footer')

@stop
