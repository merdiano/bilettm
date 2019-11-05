@extends('Bilettm.Layouts.BilettmLayout')
@section('content')
    @include('Bilettm.ViewEvent.Partials.HeaderSection')

    @include('Bilettm.ViewEvent.Partials.CreateOrderSection')

    @include('Bilettm.ViewEvent.Partials.FooterSection')
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