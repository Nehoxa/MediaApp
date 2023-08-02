<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class MovieCollection
{
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

        $movies = $this->parts; /* @phpstan-ignore-line */
        
        usort($movies, function ($firstDate, $secondDate) {
            $firstDate = ($firstDate['release_date'] !== '') ? $firstDate['release_date'] : '9999-99-99';
            $secondDate = ($secondDate['release_date'] !== '') ? $secondDate['release_date'] : '9999-99-99';
            
            if ($firstDate == $secondDate) {
                return 0;
            }
            
            return ($firstDate < $secondDate) ? -1 : 1;
        });
        
        $this->parts = $movies; /* @phpstan-ignore-line */
    }
}
