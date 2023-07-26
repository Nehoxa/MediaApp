<?php

namespace App\Providers;

use App\Services\Tmdb\TmdbService;
use Illuminate\Support\ServiceProvider;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('tmdb', fn () => new TmdbService(config('tmdb')));
    }
}
