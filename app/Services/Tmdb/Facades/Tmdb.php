<?php

namespace App\Services\Tmdb\Facades;

use Illuminate\Support\Facades\Facade;

class Tmdb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tmdb';
    }
}
