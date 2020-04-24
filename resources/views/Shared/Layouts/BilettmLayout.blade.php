<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>{{$title ?? 'Bilet TM'}}</title>
    <meta name="yandex-verification" content="1ee5ccb1ea1e6cc1" />
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    {{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap4/bootstrap.min.css')}}">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{asset('vendor/icon-awesome/css/font-awesome.min.css')}}">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{asset('assets/images/icons/favicon.ico')}}" type="image/x-icon">

    @yield('after_styles')

    <!-- CSS Unify Theme -->
    <link rel="stylesheet" href="{{asset('assets/stylesheet/styles.e-commerce.css')}}">

    <!--  KMB Custom css  -->
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom.css")}}'>
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom_new.css")}}'>
    @stack('after_styles')

</head>

<body>

<main id="{{$folder}}">
    @include($folder.'.Partials.PublicHeader')
    @yield('content')
    @stack('after_content')
    @include($folder.'.Partials.PublicFooter')
</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/popper.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

<script src="{{ asset('vendor/chosen/chosen.jquery.js') }}"></script>
{{--<script src="{{ asset('vendor/jquery-ui/ui/widgets/datepicker.js') }}"></script>--}}

@yield('after_scripts')

@stack('after_scripts')
<script>
    $('document').ready(function(){
        $('#top-header-submit').click(function(){
            $('#main-header-search-form').submit();
        });
    });
    function lang(key, params) {
        /* Line below will generate localization helpers warning, that it will not be included in search.
        * It is understandable, but I have no idea how to turn it off.*/
        var data = <?=json_encode(trans("Javascript"))?>;
        var string = data[key];
        if(typeof string == 'undefined')
            return key;
        for(var k in params) {
            string = string.split(":"+k).join(params[k]);
        }
        return string;
    }
</script>

{!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}
@if(session()->get('message'))
    <script>showMessage('{{\Session::get('message')}}');</script>
@endif
</body>
