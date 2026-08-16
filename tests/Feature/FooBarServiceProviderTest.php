<?php

namespace Tests\Feature;

use App\Contracts\HelloService;
use App\Data\Foo;
use App\Data\Bar;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
    public function testServiceProvider(){
     $foo1 = $this->app->make(Foo::class);
     $foo2 = $this->app->make(Foo::class);
     $bar1 = $this->app->make(Bar::class);
     $bar2 = $this->app->make(Bar::class);

     self::assertSame($foo1,$foo2);
     self::assertSame($bar1,$bar2);
     self::assertSame($foo1,$bar1->foo);
     self::assertSame($foo2,$bar2->foo);
     
    }

    public function testHelloService(){

        $hello1 = $this->app->make(HelloService::class);
        $hello2 = $this->app->make(HelloService::class);


        self::assertSame($hello1,$hello2);

        self::assertEquals("Halo Afrizal",$hello1->hello('Afrizal'));
        self::assertEquals("Halo Afrizal", $hello2->hello('Afrizal'));

    }

  
        
        
}
