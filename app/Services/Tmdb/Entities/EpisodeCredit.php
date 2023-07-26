<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class EpisodeCredit
{
    public int $id;
    public array $cast; /** @phpstan-ignore-line */
    public array $crew; /** @phpstan-ignore-line */
    public array $guestStars; /** @phpstan-ignore-line */
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
