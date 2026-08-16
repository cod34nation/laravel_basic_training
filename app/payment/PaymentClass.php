<?php

namespace App\payment;

class PaymentClass  
{
    private $paymentClass;

    public function setMethod($m){
        $this->paymentClass = $m;
    }
    public function __construct($paymentClass)
    {
        $this->paymentClass = $paymentClass;
    }
    public function excecute()
    {
        dd($this->paymentClass);
    }
}
