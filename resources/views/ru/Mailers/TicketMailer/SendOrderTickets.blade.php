@extends('ru.Emails.Layouts.Master')

@section('message_content')
    Здравствуйте,<br><br>

    Ваша покупка билета на мероприятие <b>{{$order->event->title}}</b> прошла успешна.<br><br>

    Ваши билеты прилагаются к этому письму. Вы также можете просмотреть информацию о заказе и скачать билеты по адресу: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

@if(!$order->is_payment_received)
<br><br>
<b>Обратите внимание: этот заказ все еще требует оплаты. Инструкции по оплате можно найти на странице вашего заказа.: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</b>
<br><br>
@endif
<h3>Информация о заказе</h3>
    Код заказа: <b>{{$order->order_reference}}</b><br>
    Имя покупателя: <b>{{$order->full_name}}</b><br>
    Дата заказа: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
    Электронная почта покупателя: <b>{{$order->email}}</b><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Добавить в календарь</a>
<h3>Подробности заказа</h3>
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
                <b>Плата за обслуживание</b>
            </td>
            <td>
                <b>Итого</b>
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
                                            БЕСПЛАТНО
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
{{--        <tr>--}}
{{--            <td>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                <b>Промежуточный итог</b>--}}
{{--            </td>--}}
{{--            <td colspan="2">--}}
{{--                {{$orderService->getOrderTotalWithBookingFee(true)}}--}}
{{--            </td>--}}
{{--        </tr>--}}
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
                <b>Итого</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Спасибо!
@stop
