<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Checkout Result Successful</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap4/bootstrap.min.css')}}">


</head>

<body style="background-color: #1d1d26; color: white;">

<main>

    <section id="order_form" class="container">
        <div class="row">
            <div class="col-12 order_header mt-5">

                <h5>@lang("Public_ViewEvent.thank_you_for_your_order")</h5>
                <p class="mt-3">
                    @lang("Public_ViewEvent.mobile_tickets_sent_email")
                </p>
            </div>
        </div>
        @if($event->post_order_display_message)
        <div class="row mt-3">
            <div class="col-12">

                    <div class="alert alert-dismissable alert-info">
                        {{ nl2br(e($event->post_order_display_message)) }}
                    </div>


            </div>
        </div>
        @endif
        <div class="row mt-3">
            <div class="col-5">
                <b>@lang("Attendee.first_name")</b><br> <small>{{$order->first_name}}</small>
            </div>
            <div class="col-7">
                <b>@lang("Attendee.last_name")</b><br> <small>{{$order->last_name}}</small>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-5">
                <b>@lang("Public_ViewEvent.reference")</b><br> <small>{{$order->order_reference}}</small>
            </div>
            <div class="col-7">
                <b>@lang("Public_ViewEvent.amount")</b><br> <small>{{number_format($order->total_amount, 2)}} man.</small>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-5">
                <b>@lang("Public_ViewEvent.date")</b><br> <small>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</small>
            </div>

            <div class="col-7">
                <b>@lang("Public_ViewEvent.email")</b><br> <small>{{$order->email}}</small>
            </div>
        </div>
    </section>

</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

</body>
