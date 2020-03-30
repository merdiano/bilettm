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

<body style="background-color: #0b011d; color: white;">

<main>

    <section id="order_form" class="container">
        <div class="row">
            <div class="col-12 order_header mt-5">

                <h4>@lang("Public_ViewEvent.thank_you_for_your_order")</h4>
                <h5>
                    @lang("Public_ViewEvent.mobile_tickets_sent_email")
                </h5>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if($event->post_order_display_message)
                    <div class="alert alert-dismissable alert-info">
                        {{ nl2br(e($event->post_order_display_message)) }}
                    </div>
                @endif

            </div>
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <b>@lang("Attendee.first_name")</b><br> {{$order->first_name}}
            </div>
            <div class="col-6">
                <b>@lang("Attendee.last_name")</b><br> {{$order->last_name}}
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-6">
                <b>@lang("Public_ViewEvent.reference")</b><br> {{$order->order_reference}}
            </div>
            <div class="col-6">
                <b>@lang("Public_ViewEvent.amount")</b><br> {{number_format($order->total_amount, 2)}} man.
            </div>

        </div>
        <div class="row mt-5">
            <div class="col-6">
                <b>@lang("Public_ViewEvent.date")</b><br> {{$order->created_at->toDateTimeString()}}
            </div>

            <div class="col-6">
                <b>@lang("Public_ViewEvent.email")</b><br> {{$order->email}}
            </div>
        </div>
    </section>

</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

</body>
