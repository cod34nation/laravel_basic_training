<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadesTest extends TestCase
{
    
    public function testConfig() {
        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName1,$firstName2);

    }

    public function testConfigDepedency() {
        $config = $this->app->make('config');
        $firstName3= $config->get('contoh.author.first');

        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');
        

        
        self::assertEquals($firstName1,$firstName3);
        self::assertEquals($firstName2, $firstName3);

    }

    public function testFacadeMock (){
        Config::shouldReceive('get')->with('contoh.author.first')->andReturn('Afrizal Okay');

        $firstName = Config::get('contoh.author.first');
        self::assertEquals('Afrizal Okay',$firstName);
    }

    

}

