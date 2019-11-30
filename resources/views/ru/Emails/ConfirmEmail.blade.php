@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Привет! {{$first_name}}</p>
<p>
    Спасибо за регистрацию для {{ config('attendize.app_name') }}. Мы рады, что вы на борту.
</p>

<p>
    Вы можете создать свое первое событие и подтвердить свой адрес электронной почты, используя ссылку ниже.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Если у вас есть какие-либо вопросы, отзывы или предложения, не стесняйтесь ответить на это письмо.
</p>
<p>
    Спасибо!
</p>

@stop

@section('footer')


@stop
