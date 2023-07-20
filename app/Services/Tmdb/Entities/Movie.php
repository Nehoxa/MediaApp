<?php

namespace App\Services\Tmdb\Entities;

class Movie
{
    public bool $adult;
    public string $backdropPath;
    public ?array $belongsToCollection;
    public int $budget;
    public array $genres;
    public string $homepage;
    public int $id;
    public string $imdbId;
    public string $originalLanguage;
    public string $originalTitle;
    public string $overview;
    public float $popularity;
    public string $posterPath;
    public array $productionCompanies;
    public array $productionCountries;
    public string $releaseDate;
    public int $revenue;
    public int $runtime;
    public array $spokenLanguages;
    public string $status;
    public string $tagline;
    public string $title;
    public bool $video;
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
