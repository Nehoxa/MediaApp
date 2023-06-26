<?php

namespace App\Services\Tmdb;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TmdbService
{
    public function __construct(protected array $config)
    {
    }

    protected function get(string $uri, array $params = []): Response
    {
        $params = array_merge($params, [
            'api_key', $this->config['api_key'],
            'language', $this->config['language'],
        ]);

        return Http::get($this->config['endpoint'] . $uri, $params);
    }

    public function moviesList(): mixed
    {
        return $this->get('genre/movie/list')->json();
    }
}
