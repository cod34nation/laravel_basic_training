<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet() {
        $this->get('/afrizal')->assertStatus(200)->assertSee('Hello Afrizal');
    }
    public function testRedirect() {
        $this->get('/youtube')->assertRedirect('/afrizal');
        
    }

    public function testParameter(){
        $this->get('testParameter/123')->assertSeeText("Product ID: 123");
    }

    public function testMultiParameter(){
        $this->get('/parameter/123/paramater2/456')->assertSeeText("Parameter 1: 123" . "Parameter 2: 456");
    }
    public function routeParameterRegex( ){
        $this->get('/parameter/abc')->assertSeeText("Parameter: abc");
        $this->get('/parameter/123')->assertSeeText("Parameter: 123");
    }
    public function parameterOptional( ){
        $this->get('/parameterOptional/123')->assertSeeText("Parameter: 123");
        $this->get('/parameterOptional')->assertSeeText("Parameter: 404 Not Found");
    }

    public function testNameRoute () {
        $this->get('product/123')->assertSeeText("Link: http://localhost/product/123");
    }

}



