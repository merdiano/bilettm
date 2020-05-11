@extends('Emails.Layouts.Master')
@section('message_content')
    <p>Здравствуйте! {{$first_name}}</p>
    <p>
        Спасибо за регистрацию на сайте {{ config('attendize.app_name') }}, в качестве организатора.
    </p>

    <p>
        Вы можете создать мероприятие на сайте, подтвердив свой адрес электронной почты, используя ссылку ниже.
    </p>

    <div style="padding: 5px; border: 1px solid #ccc;">
        {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
    </div>
    <br><br>
    <p>
        Если у вас есть какие-либо вопросы, отзывы или предложения, обращайтесь к нам.
    </p>
    <p>
        Спасибо!
    </p>
@endsection
