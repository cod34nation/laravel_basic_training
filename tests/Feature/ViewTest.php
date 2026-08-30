<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView () {
        $this->get('/hello')->assertSeeText("hello Afrizal");

    }

    public function testNested (){

        $this->get('/hello-world')->assertSeeText("hello dunia");
        

}

public function testViewWithoutRouting (){
    $this->view('hello.world',['name'=> 'Afrizal Wibisono'])->assertSeeText("hello Afrizal Wibisono");
}


}  