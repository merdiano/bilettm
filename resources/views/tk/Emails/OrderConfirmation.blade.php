@extends('tk.Emails.Layouts.Master')

@section('message_content')
Salam!<br><br>

Siziň <b>{{$order->event->title}}</b> çäresi üçin sargydyňyz üstünlikli ýerine ýetirildi.<br><br>

Siziň petekleriňiz şu poçta birikdirildi. Siz şeýle hem öz sargydyňyz barada maglumatlary we petekleri ýüklemek üçin şu linki ullanyp bilersiňiz: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Sargyt barada maglumat</h3>
Sargydyň belgisi: <b>{{$order->order_reference}}</b><br>
Sargydyň ady: <b>{{$order->full_name}}</b><br>
Sargydyň Wagty: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Sargydyň poçtasy: <b>{{$order->email}}</b><br>

<h3>Sargalan petekleriň sanawy</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Petekler</b>
            </td>
            <td>
                <b>Mukdary</b>
            </td>
            <td>
                <b>Bahasy</b>
            </td>
            <td>
                <b>Salgydy</b>
            </td>
            <td>
                <b>Umumy</b>
            </td>
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
</div>
<br><br>
Sag boluň!
@stop
