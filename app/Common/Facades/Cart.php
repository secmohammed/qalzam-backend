<?php


namespace App\Common\Facades;


use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'cart';
    }
}
