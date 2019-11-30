@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        Salam!<br><br>
        Açar sözüni täzelemek üçin, aşakdaky boş ýerleri dolduryň: {{ route('password.reset', ['token' => $token]) }}.
        <br><br><br>
        Sag boluň!<br>
        Hormatlamak bilen Bilettm topary.
    </div>
@stop