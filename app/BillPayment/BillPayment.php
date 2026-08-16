<?php

namespace App\BillPayment;

use App\payment\PaymentClass;


class BillPayment 
{
   private PaymentClass $paymentClass;
   public function __construct (PaymentClass $payment){

    $this->paymentClass = $payment;

   }

   public function pay() {
    $this->paymentClass->excecute();
   }

}
