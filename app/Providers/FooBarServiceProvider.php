<?php

namespace App\Providers;

use App\Contracts\HelloService;
use App\Contracts\HelloServicesIndonesia;
use Illuminate\Support\ServiceProvider;
use App\Data\Foo;
use App\Data\Bar;
use Illuminate\Contracts\Support\DeferrableProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{   
    
    public array $singletons = [
        HelloService::class => HelloServicesIndonesia::class
    ];

    public function register(): void
    {
        $this->app->singleton(Foo::class,function($app){
            return new Foo();
        });
        $this->app->singleton(Bar::class,function($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array {
        return [
            HelloService::class,
            Foo::class,
            Bar::class
        ];
    }
}
