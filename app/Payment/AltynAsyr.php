<?php

namespace App\Payment;

use App\Models\Order;
use App\Services\EventOrderService as OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AltynAsyr extends Payment
{
    protected $code  = 'altynasyr';

    public function registerPaymentOrder($order_reference, $total_amount,$event_id,):RegistrationResponse
    {
        $exp = session()->get('ticket_order_' . $event_id.'.expires');
        $secondsToExpire = Carbon::now()->diffInSeconds($exp);

        $transaction_data['form_params'] = [
            'amount'      => $total_amount * 100 ,
            'sessionTimeoutSecs' => $secondsToExpire,
            'description' => 'bilettm sargyt: ' . request()->get('order_email'),
            'orderNumber' => $order_reference,
            'failUrl'     => route('showEventCheckoutPaymentReturn', [
                'event_id'              => $event_id,
                'is_payment_cancelled'  => 1
            ]),
            'returnUrl'   => route('showEventCheckoutPaymentReturn', [
                'event_id'              => $event_id,
                'is_payment_successful' => 1
            ]),
            config("payment.altynasyr.form_params")
        ];

            $request = $this->client->post('register.do',$transaction_data);

            return new AltynAsyrRegistrationResponse($request->getBody());

    }

    public function getPaymentStatus($orderId):StatusResponse
    {
        $params['form_params'] = config('payment.'.$this->code.'.form_params');
        $params['form_params']['orderId'] = $orderId;
        $request = $this->client->post('getOrderStatus.do',$params);

        return new AltynAsyrStatusResponse($request->getBody());
    }

}