<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class Person
{
    public bool $adult;
    public array $alsoKnownAs; /** @phpstan-ignore-line */
    public string $biography;
    public ?string $birthday;
    public ?string $deathday;
    public int $gender;
    public ?string $homepage;
    public int $id;
    public ?string $imdbId;
    public ?string $knownForDepartment;
    public string $name;
    public ?string $placeOfBirth;
    public float $popularity;
    public ?string $profilePath;
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
