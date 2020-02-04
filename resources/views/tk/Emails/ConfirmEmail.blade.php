@extends('tk.Emails.Layouts.Master')

@section('message_content')

<p>Salam! {{$first_name}}</p>
<p>
    {{ config('attendize.app_name') }} registrasiýa geçeniňiz üçin sag boluň. Biz siziň biziň bilendigiňize minnetdar.
</p>

<p>
    Siz öz e-poçta belgiňizi tassyklap we ilkinji çäräňizi şu aşakdaky link boýunça goşup bilersiňiz.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Eger-de sizde sorag bar bolsa, şu poçta jogap berip bilersiňiz.
</p>
<p>
    Sag boluň!
</p>

@stop

@section('footer')


@stop
