<?php

namespace App\payment;

class MidtransMethod implements PaymentInterface
{

    public function inquiry() {
        
    }
    public function execute()
    {
        dd('MIDTRANS');
    }
     
}
