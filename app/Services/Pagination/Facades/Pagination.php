<?php

namespace App\Services\Pagination\Facades;

use Illuminate\Support\Facades\Facade;

class Pagination extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'pagination';
    }
}
