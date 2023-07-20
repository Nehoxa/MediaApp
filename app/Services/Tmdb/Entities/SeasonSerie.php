<?php

namespace App\Services\Tmdb\Entities;

class SeasonSerie
{
    public string $_id;
    public string $airDate;
    public array $episodes;
    public string $name;
    public ?string $overview;
    public string $id;
    public string $posterPath;
    public int $seasonNumber;
    public float $voteAverage;
    public int $statusCode;
    public string $statusMessage;
    
    public function __construct($data)
    {
        $collection = collect($data->json());

        if ($data->getStatusCode() === 200) {
            foreach ($collection as $key => $value) {
                $CamelCaseKey = lcfirst(str_replace('_', '', ucwords($key, '_')));          
                $this->$CamelCaseKey = $collection->get($key);
            }
            $this->statusCode = $data->getStatusCode();
            $this->statusMessage = $data->getReasonPhrase();
        } else {
            $this->statusCode = $data->getStatusCode();
            $this->statusMessage = $collection->get('status_message');
        }
    }
}
