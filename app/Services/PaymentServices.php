<?php

namespace App\Services;

use App\Contracts\PaymentInterface;

class PaymentServices implements PaymentInterface
{
      public function pay(int $amount):string {
        return "Payment  of Rp {$amount} successfully";
      }
}
