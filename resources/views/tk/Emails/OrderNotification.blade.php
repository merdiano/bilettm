@extends('en.Emails.Layouts.Master')

@section('message_content')
Salam!<br><br>

Siz <b>{{$order->event->title}} çäresi üçin täze sargyt aldyňyz</b>.<br><br>

@if(!$order->is_payment_received)
    <b>Haýyş edýäris üns beriň: Bu sargyt entek hem töleg talap edýär.</b>
    <br><br>
@endif


Sargydyň gysgaça maglumatlary:
<br><br>
Sargydyň belgisi: <b>{{$order->order_reference}}</b><br>
Sargydyň ady: <b>{{$order->full_name}}</b><br>
Sargydyň wagty: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Sargydyň poçtasy: <b>{{$order->email}}</b><br>


<h3>Sargydyň petekleri</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">

    <table style="width:100%; margin:10px;">
        <tr>
            <th>
                Petekler
            </th>
            <th>
                Mukdary
            </th>
            <th>
                Bahasy
            </th>
            <th>
                Sargamak üçin salgydy
            </th>
            <th>
                Umumy
            </th>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>
                {{$order_item->title}}
            </td>
            <td>
                {{$order_item->quantity}}
            </td>
            <td>
                @if((int)ceil($order_item->unit_price) == 0)
                MUGT
                @else
                {{money($order_item->unit_price, $order->event->currency)}}
                @endif

            </td>
            <td>
                @if((int)ceil($order_item->unit_price) == 0)
                -
                @else
                {{money($order_item->unit_booking_fee, $order->event->currency)}}
                @endif

            </td>
            <td>
                @if((int)ceil($order_item->unit_price) == 0)
                MUGT
                @else
                {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                @endif

            </td>
        </tr>
        @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Orta umumy</b>
            </td>
            <td colspan="2">
                {{$orderService->getOrderTotalWithBookingFee(true)}}
            </td>
        </tr>
        @if($order->event->organiser->charge_tax == 1)
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>{{$order->event->organiser->tax_name}}</b>
            </td>
            <td colspan="2">
                {{$orderService->getTaxAmount(true)}}
            </td>
        </tr>
        @endif
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Umumy</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>


    <br><br>
    Siz bu sargyda şu link boýunça gidip gözegçilik edip bilersiňiz: {{route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])}}
    <br><br>
</div>
<br><br>
Sag boluň!
@stop
