<?php

namespace Tests\Feature;

use App\Data\foo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function DepedencyTestCase() {
        $foo = $this->app->make(foo::class);

        self::assertEquals("Foo",$foo->foo());

    }

}

