<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>{{$title ?? 'Bilet TM'}}</title>

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

    @yield('after_styles')


    <!-- CSS Unify Theme -->
    <link rel="stylesheet" href="{{asset('assets/stylesheet/styles.e-commerce.css')}}">

    <!--  KMB Custom css  -->
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom.css")}}'>
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom_new.css")}}'>
    @stack('after_styles')

</head>

<body>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="padding: 50px 70px">
            @include('Shared.Partials.AddEventForm')
        </div>
    </div>
</div>
<main>
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
</script>
@if(session()->get('message'))
    <script>showMessage('{{\Session::get('message')}}');</script>
@endif
</body>
