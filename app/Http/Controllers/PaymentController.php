<?php

namespace App\Http\Controllers;

use App\payment\PaymentInterface;

class PaymentController extends Controller
{
    public function index(PaymentInterface $paymentInterface ) {  
        
        $paymentInterface->execute();
    }
    
}
