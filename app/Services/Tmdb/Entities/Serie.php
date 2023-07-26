<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class Serie
{
    public bool $adult;
    public ?string $backdropPath;
    public array $createdBy; /** @phpstan-ignore-line */
    public array $episodeRunTime; /** @phpstan-ignore-line */
    public string $firstAirDate;
    public array $genres; /** @phpstan-ignore-line */
    public string $homepage;
    public int $id;
    public bool $inProduction;
    public array $languages; /** @phpstan-ignore-line */
    public string $lastAirDate;
    public array $lastEpisodeToAir; /** @phpstan-ignore-line */
    public string $name;
    public ?array $nextEpisodeToAir; /** @phpstan-ignore-line */
    public array $networks; /** @phpstan-ignore-line */
    public int $numberOfEpisodes;
    public int $numberOfSeasons;
    public array $originCountry; /** @phpstan-ignore-line */
    public string $originalLanguage;
    public string $originalName;
    public string $overview;
    public float $popularity;
    public ?string $posterPath;
    public array $productionCompanies; /** @phpstan-ignore-line */
    public array $productionCountries; /** @phpstan-ignore-line */
    public array $seasons; /** @phpstan-ignore-line */
    public array $spokenLanguages; /** @phpstan-ignore-line */
    public string $status;
    public string $tagline;
    public string $type;
    public float $voteAverage;
    public int $voteCount;
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
