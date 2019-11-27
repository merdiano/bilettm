@extends('en.Emails.Layouts.Master')

@section('message_content')
    Здравствуйте,<br><br>

    Ваш заказ на мероприятие <b>{{$order->event->title}}</b> был успешен.<br><br>

    Ваши билеты прилагаются к этому письму. Вы также можете просмотреть информацию о заказе и скачать билеты по адресу: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Информация для заказа</h3>
    Код заказа: <b>{{$order->order_reference}}</b><br>
    Название заказа: <b>{{$order->full_name}}</b><br>
    Дата заказа: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
    Электронная почта заказа: <b>{{$order->email}}</b><br>

<h3>Электронная почта заказа</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Билет</b>
            </td>
            <td>
                <b>Количество.</b>
            </td>
            <td>
                <b>Цена</b>
            </td>
            <td>
                <b>Плата</b>
            </td>
            <td>
                <b>Общее</b>
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
                                        FREE
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
                                        БЕСПЛАТНО
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
                <b>Промежуточный итог</b>
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
                <b>Итог</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Thank you
@stop