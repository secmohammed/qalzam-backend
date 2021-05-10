<?php


namespace App\Common\Facades;

use Illuminate\Support\Facades\Facade;

class Branch extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'branch';
    }

}
