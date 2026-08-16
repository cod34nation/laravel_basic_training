<?php

namespace Tests\Feature;

use App\Contracts\HelloServicesIndonesia;
use App\Contracts\HelloService;
use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{

  public function testDepedency() {
   // $foo = new Foo();
   $foo1 = $this->app->make(Foo::class); //new Foo()
   $foo2 = $this->app->make(Foo::class); //new Foo()

   self::assertEquals("Foo",$foo1->foo());
   self::assertEquals("Foo",$foo2->foo());
   self::assertNotSame($foo1,$foo2);

   

  }

  public function testServiceContainerBind() {

    $this->app->bind(Person::class,function($app){
        return new Person("Afrizal","Wibisono");
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Afrizal",$person1->firstName);
    self::assertEquals("Afrizal",$person2->firstName);
    self::assertNotSame($person1,$person2);
    

  }

  public function testServiceContainerSingleton() {
    $this->app->singleton(Person::class, function($app){
        return new Person("Afrizal","Wibisono");
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Afrizal",$person1->firstName);
    self::assertEquals("Afrizal",$person2->firstName);
    self::assertSame($person1,$person2);

  }

  public function testServiceContainerInstance() {
    $person = new Person("Afrizal","Wibisono");
    $this->app->instance(Person::class,$person);

    $person1= $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Afrizal",$person1->firstName);
    self::assertEquals("Afrizal",$person2->firstName);
    self::assertSame($person1,$person2);
    self::assertSame($person,$person1);


}

public function testDepedencyInjection (){
    $foo = $this->app->singleton(Foo::class,function($app){
        return new Foo();
    });

    $foo = $this->app->make(Foo::class);
    $bar = $this->app->make(Bar::class);

    self::assertEquals("Foo",$foo->foo());
    self::assertEquals("Foo and Bar",$bar->bar());


}

public function testDepedencyInjectionClosure(){
    $this->app->singleton(Foo::class, function ($app){
        return new Foo();
    });

    $this->app->singleton(Bar::class,function($app){
        return new Bar($app->make(Foo::class));
    });

    $bar1 = $this->app->make(Bar::class);
    $bar2 = $this->app->make(Bar::class);

    self::assertEquals("Foo and Bar", $bar1->bar());
    self::assertEquals("Foo and Bar", $bar2->bar());
    self::assertSame($bar1,$bar2);

}
public function testDepedencyInterface() {

    $this->app->singleton(HelloService::class,HelloServicesIndonesia::class);
    
    $hello = $this->app->make(HelloService::class);
    self::assertEquals("Halo Afrizal",$hello->hello("Afrizal"));

}

}

