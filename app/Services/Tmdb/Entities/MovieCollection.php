<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class MovieCollection
{
    public int $id;
    public string $name;
    public string $overview;
    public string $posterPath;
    public ?string $backdropPath;
    public array $parts; /** @phpstan-ignore-line */
    public int $statusCode;
    public string $statusMessage;

    public function __construct(Response $data)
    {
        $collection = collect((array) $data->json());

        if ($data->status() === 200) {
            foreach ($collection as $key => $value) {
                $camelCaseKey = str($key)->camel();
                $this->$camelCaseKey = $collection->get($key);
            }
            $this->statusCode = $data->status();
            $this->statusMessage = $data->reason();
        } else {
            $this->statusCode = $data->status();
            $this->statusMessage = $collection->get('status_message');
        }

        $movies = $this->parts;
        
        usort($movies, function ($a, $b) {
            $dateA = ($a['release_date'] !== '') ? $a['release_date'] : '9999-99-99';
            $dateB = ($b['release_date'] !== '') ? $b['release_date'] : '9999-99-99';
            
            if ($dateA == $dateB) {
                return 0;
            }
            
            return ($dateA < $dateB) ? -1 : 1;
        });
        
        $this->parts = $movies;
    }
}
