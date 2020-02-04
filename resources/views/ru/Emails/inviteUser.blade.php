@extends('ru.Emails.Layouts.Master')

@section('message_content')

<p>Здравствуйте</p>
<p>
     {{$inviter->first_name.' '.$inviter->last_name}} вас добавил к {{ config('attendize.app_name') }}.
</p>

<p>
    Вы можете войти {{url('/login')}}, используя следующие данные:<br><br>

    имя пользователя: <b>{{$user->email}}</b> <br>
    пароль: <b>{{$temp_password}}</b>
</p>

<p>
    Вы можете изменить свой временный пароль, после входа в систему.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    Вы можете изменить свой временный пароль, после входа в систему.
</p>
<p>
    Спасибо
</p>

@stop

@section('footer')


@stop
