<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class EpisodeSerie
{
    public string $airDate;
    public array $crew; /** @phpstan-ignore-line */
    public int $episodeNumber;
    public array $guestStars; /** @phpstan-ignore-line */
    public string $name;
    public string $overview;
    public int $id;
    public ?string $productionCode;
    public ?int $runtime;
    public int $seasonNumber;
    public ?string $stillPath;
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
