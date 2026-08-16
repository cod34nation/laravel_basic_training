<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Data\Foo;
use App\Data\Bar;

class DepedencyInjectionTest extends TestCase
{
   
    public function testDepedencyInjection() {
        
        $foo = new Foo() ;
        $bar = new Bar($foo);

        self::assertEquals("Foo and Bar",$bar->bar());
    }
        

}
