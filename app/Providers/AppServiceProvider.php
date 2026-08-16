<?php

namespace App\Providers;

use App\payment\MidtransMethod;
use App\payment\GopayMethod;
use App\payment\PaymentInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentInterface::class,function ($app){
            
            if(request()->pay_method == "md"){
                return new MidtransMethod();
            }else{
                return new GopayMethod();
            }

        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
