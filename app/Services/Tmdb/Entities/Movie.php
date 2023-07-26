<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class Movie
{
    public bool $adult;
    public ?string $backdropPath;
    public ?array $belongsToCollection; /** @phpstan-ignore-line */
    public int $budget;
    public array $genres; /** @phpstan-ignore-line */
    public string $homepage;
    public int $id;
    public ?string $imdbId;
    public string $originalLanguage;
    public string $originalTitle;
    public string $overview;
    public float $popularity;
    public ?string $posterPath;
    public array $productionCompanies; /** @phpstan-ignore-line */
    public array $productionCountries; /** @phpstan-ignore-line */
    public string $releaseDate;
    public int $revenue;
    public int $runtime;
    public array $spokenLanguages; /** @phpstan-ignore-line */
    public string $status;
    public string $tagline;
    public string $title;
    public bool $video;
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
