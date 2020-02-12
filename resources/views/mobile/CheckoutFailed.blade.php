<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Checkout Result Successful</title>

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

<main>
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 property="name" style="font-weight: bold">Töleg geçmedi. Birsalymdan gaýtadan synanşyp görüň!</h2>
            </div>
        </div>
    </section>
    <section id="order_form" class="container">

        <h3> {{$message}}</h3>
    </section>

</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

</body>
