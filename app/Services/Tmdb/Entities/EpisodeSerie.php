<?php

namespace App\Services\Tmdb\Entities;

class EpisodeSerie
{
    public string $airDate;
    public array $crew;
    public int $episodeNumber;
    public array $guestStars;
    public string $name;
    public string $overview;
    public int $id;
    public ?string $productionCode;
    public int $runtime;
    public int $seasonNumber;
    public string $stillPath;
    public float $voteAverage;
    public int $voteCount;
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
