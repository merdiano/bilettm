@extends('Shared.Layouts.BilettmLayout',['folder' => 'desktop'])
@section('content')

    @include('desktop.Partials.CreateOrderSection')

    @include('desktop.Partials.FooterSection')
@endsection
@section('after_scripts')
    @include("Shared.Partials.LangScript")
    {!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}
    <script>
        var OrderExpires = {{strtotime($expires)}};
    </script>
    @if(isset($secondsToExpire))
        <script>if($('#countdown')) {setCountdown($('#countdown'), {{$secondsToExpire}});}</script>
    @endif
@endsection
