<?php

namespace App\Providers;

use App\Services\Tmdb\TmdbService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('tmdb', function (Application $app) {
            return new TmdbService($app['config']['tmdb']);
        });
    }
}
