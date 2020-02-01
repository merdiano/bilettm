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


<!-- CSS Unify Theme -->
    <link rel="stylesheet" href="{{asset('assets/stylesheet/styles.e-commerce.css')}}">

    <!--  KMB Custom css  -->
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom.css")}}'>
    <link rel="stylesheet" href='{{asset("assets/stylesheet/custom_new.css")}}'>

</head>

<body>

<main>

    <section id="order_form" class="container">
        <div class="row">
            <div class="col-md-12 order_header">
            <span class="massive-icon">
                <i class="ico ico-checkmark-circle"></i>
            </span>
                <h3>@lang("Public_ViewEvent.thank_you_for_your_order")</h3>
                <h4>
                    @lang("Public_ViewEvent.your")
                    <a class="ticket_download_link"
                       href="{{ route('showOrderTickets', ['order_reference' => $order->order_reference] ).'?download=1' }}">
                        @lang("Public_ViewEvent.tickets") </a>  @lang("Public_ViewEvent.confirmation_email")
                </h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="content event_view_order">

                    @if($event->post_order_display_message)
                        <div class="alert alert-dismissable alert-info">
                            {{ nl2br(e($event->post_order_display_message)) }}
                        </div>
                    @endif

                    <div class="order_details well">
                        <div class="row">
                            <div class="col-6">
                                <b>@lang("Attendee.name")</b><br> {{$order->full_name}}
                            </div>

                            <div class="col-6">
                                <b>@lang("Public_ViewEvent.amount")</b><br> {{number_format($order->total_amount, 2)}} man.
                                @if($event->organiser->charge_tax)
                                    <small>{{ $orderService->getVatFormattedInBrackets() }}</small>
                                @endif
                            </div>

                            <div class="col-4">
                                <b>@lang("Public_ViewEvent.reference")</b><br> {{$order->order_reference}}
                            </div>

                            <div class="col-4">
                                <b>@lang("Public_ViewEvent.date")</b><br> {{$order->created_at->toDateTimeString()}}
                            </div>

                            <div class="col-4">
                                <b>@lang("Public_ViewEvent.email")</b><br> {{$order->email}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<!-- JS Global Compulsory -->
<script src="{{asset('assets/javascript/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap4/bootstrap.min.js')}}"></script>

</body>
