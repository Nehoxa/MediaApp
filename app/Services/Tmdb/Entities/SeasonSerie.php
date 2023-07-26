<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class SeasonSerie
{
    public string $_id;
    public string $airDate;
    public array $episodes; /** @phpstan-ignore-line */
    public string $name;
    public ?string $overview;
    public string $id;
    public ?string $posterPath;
    public int $seasonNumber;
    public float $voteAverage;
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
    }
}
