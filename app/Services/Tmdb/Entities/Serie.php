<?php

namespace App\Services\Tmdb\Entities;

class Serie
{
    public bool $adult;
    public string $backdropPath;
    public array $createdBy;
    public array $episodeRunTime;
    public string $firstAirDate;
    public array $genres;
    public string $homepage;
    public int $id;
    public bool $inProduction;
    public array $languages;
    public string $lastAirDate;
    public array $lastEpisodeToAir;
    public string $name;
    public array $nextEpisodeToAir;
    public array $networks;
    public int $numberOfEpisodes;
    public int $numberOfSeasons;
    public array $originCountry;
    public string $originalLanguage;
    public string $originalName;
    public string $overview;
    public float $popularity;
    public string $posterPath;
    public array $productionCompanies;
    public array $productionCountries;
    public array $seasons;
    public array $spokenLanguages;
    public string $status;
    public string $tagline;
    public string $type;
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
