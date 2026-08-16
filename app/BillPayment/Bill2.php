<?php

namespace App\BillPayment;

use App\payment\PaymentClass;

class Bill2
{
    /**
     * Create a new class instance.
     */
    private PaymentClass $paymentClass; 
    public function __construct(PaymentClass $p)
    {
        $this->paymentClass = $p;
    }

    public function pay2() {
        $this->paymentClass->excecute();
        
    }
}
