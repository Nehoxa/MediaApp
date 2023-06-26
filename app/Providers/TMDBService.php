<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class TMDBService extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind('tmdb', function () {
            return new Client([
                'base_uri' => 'https://api.themoviedb.org/3/',
                'query' => ['api_key' => env('TMDB_API_KEY')],
            ]);
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
