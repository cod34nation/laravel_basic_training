<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnviromentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetenv(){
        $youtube = env('YOUTUBE');
        self::assertEquals("Afrizal Chanel",$youtube);
    }
}
