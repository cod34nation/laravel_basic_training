<?php

namespace App\Contracts;

interface PaymentInterface {
    function pay(int $amount):string;
}

