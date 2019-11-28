Salam! {{{$attendee->first_name}}},<br><br>

Biz siziň petekleriňizi şu poçta birikdirdik.<br><br>

Siz öz sargydyňyz barada maglumatlary ýa-da bilediňizi şu link {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}} boýunça her wagt alyp bilersiziňiz.<br><br>

Siziň sargydyňyzyň belgisi <b>{{$attendee->order->order_reference}}</b>.<br>

Sag boluň!<br>

