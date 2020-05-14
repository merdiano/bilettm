<?php
/**
 * Created by PhpStorm.
 * User: merdan
 * Date: 8/16/2019
 * Time: 13:30
 */

namespace App\Payment;


abstract class PaymentResponse
{
    protected $response_data;
    protected $exception_message;

    public function setResponseData($data){
//        dd(json_decode($data, true));
        $rsp = json_decode($data, true);
        if($rsp)
            $this->response_data = $rsp;
        else
            $this->exception_message = 'Bank connection failed. Please try again later!';

    }

    public function setExceptionMessage($message){
        $this->exception_message = $message;
    }

    public function errorMessage(){
        if(!$this->exception_message)
        {
            return $this->response_data['errorMessage'];}
        else
            return $this->exception_message;
    }

    public abstract function isSuccessfull();
    public abstract function getPaymentReferenceId();
}
