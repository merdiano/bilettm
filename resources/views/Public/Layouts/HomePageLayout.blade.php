<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bilet Tm</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- CSS Global Compulsory -->

    {!!HTML::style('assets/out/bootstrap/bootstrap.min.css')!!}
    <!-- CSS Implementing Plugins -->
    {!!HTML::style('vendor/icon-awesome/css/font-awesome.min.css')!!}
    {!!HTML::style('vendor/icon-line/css/simple-line-icons.css')!!}
    {!!HTML::style('vendor/icon-hs/style.css')!!}
    {!!HTML::style('vendor/hs-megamenu/src/hs.megamenu.css')!!}

   <!-- CSS Template -->
    {!!HTML::style('assets/css/styles.op-agency.css')!!}
    {!!HTML::style('vendor/icon-material/material-icons.css')!!}
    @yield('head')
</head>
<body>
    <main>
        @yield('content')
    </main>
    <!-- JS Global Compulsory -->
    {!!HTML::script('assets/out/jquery/jquery.min.js')!!}
    {!!HTML::script('assets/out/jquery-migrate/jquery-migrate.min.js')!!}
    {!!HTML::script('assets/out/popper.min.js')!!}
    {!!HTML::script('assets/out/bootstrap/bootstrap.min.js')!!}
    {!!HTML::script('assets/out/hs-megamenu/src/hs.megamenu.js')!!}
    {!!HTML::script('assets/out/js/custom.js')!!}
    @yield('foot')
</body>
