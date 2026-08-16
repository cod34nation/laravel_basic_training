<?php

namespace App\payment;

class GopayMethod implements PaymentInterface

{
    public function inquiry()
    {
        // TODO: Implement inquiry() method.
    }
    public function execute()
    {
        dd('GOPAY');
    }   
}
