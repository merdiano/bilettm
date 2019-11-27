@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        Здраствуйте,<br><br>
        Чтобы сбросить ваш пароль, заполните данную форму: {{ route('password.reset', ['token' => $token]) }}.
        <br><br><br>
        Спасибо,<br>
        Команда Bilettm
    </div>
@stop