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

    @yield('after_styles')

    @stack('after_styles')

</head>

<body style="background-color: #1d1d26; color: white;">

<main>
    <section id="intro" class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h4 property="name" style="font-weight: bold">Töleg geçmedi. Birsalymdan gaýtadan synanşyp görüň!</h4>
            </div>
        </div>
    </section>
    <section id="order_form" class="container">

        <h5> {{$message}}</h5>
    </section>

</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

</body>
