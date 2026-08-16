<?php

namespace App\Contracts;

class HelloServicesIndonesia implements HelloService
{
    /**
     * Create a new class instance.
     */
   public function hello (String $name) :string{

    return "Halo $name";
   }
}
