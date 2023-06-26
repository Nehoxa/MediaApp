<?php

namespace App\Services\Tmdb\Facades;

use Illuminate\Support\Facades\Facade;

class TmdbFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'tmdb';
    }
}
