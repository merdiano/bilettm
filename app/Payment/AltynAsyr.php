<?php

namespace App\Payment;

use App\Models\Order;
use App\Services\EventOrderService as OrderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AltynAsyr extends Payment
{
    protected $code  = 'altynasyr';

    public function registerPaymentOrder($order_reference, $total_amount,$event_id,$secondsToExpire):RegistrationResponse
    {

        $transaction_data['form_params'] = [
            'amount'      => $total_amount * 100 ,
            'sessionTimeoutSecs' => $secondsToExpire,
            'description' => 'bilettm sargyt: ' . request()->get('order_email'),
            'orderNumber' => $order_reference,
            'failUrl'     => route('showEventCheckoutPaymentReturn', [
                'event_id'              => $event_id,
                'fail'  => 1,
                'method' => $this->code,
            ]),
            'returnUrl'   => route('showEventCheckoutPaymentReturn', [
                'event_id'              => $event_id,
                'method' => $this->code,
            ]),

        ];
        $transaction_data['form_params'] =$transaction_data['form_params'] + config("payment.".$this->code.".form_params");
//        Log::info($transaction_data);

        $response = $this->client->post('register.do',$transaction_data);

        return $this->parseResponse($response->getBody());

    }

    private function parseResponse($response){
        return new AltynAsyrRegistrationResponse(json_decode($response, true));
    }

    public function getPaymentStatus($orderId):StatusResponse
    {
        $params['form_params'] = config('payment.'.$this->code.'.form_params');
        $params['form_params']['orderId'] = $orderId;
        $response = $this->client->post('getOrderStatus.do',$params);

        return new AltynAsyrStatusResponse(json_decode($response->getBody(), true));
    }

}