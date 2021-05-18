<?php


namespace App\Common\Facades;


use Illuminate\Support\Facades\Facade;

class Wishlist extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'wishlist';
    }
}
