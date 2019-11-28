@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Salam!</p>
<p>
    Siz {{ config('attendize.app_name') }} şu akkaut bilen: {{$inviter->first_name.' '.$inviter->last_name}} goşuldyňyz.
</p>

<p>
    Siz aşakdaky maglumatlary ullanyp öz akkaundyňyza girip bilersiňiz.<br><br>
    
    Ullanyjy belgiňiz: <b>{{$user->email}}</b> <br>
    Açar sözi: <b>{{$temp_password}}</b>
</p>

<p>
    Siz öz açar söziňizi akkaunda gireniňizden soňra üýtgedip bilersiňiz.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    Eger-de siziň soraglaryňyz bar bolsa sizden şu poçta jogap bermegiňizi haýyş edýäris.
</p>
<p>
    Sag boluň!
</p>

@stop

@section('footer')


@stop
