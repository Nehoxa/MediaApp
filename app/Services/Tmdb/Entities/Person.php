<?php

namespace App\Services\Tmdb\Entities;

class Person
{
    public bool $adult;
    public array $alsoKnownAs;
    public string $biography;
    public string $birthday;
    public ?string $deathday;
    public int $gender;
    public ?string $homepage;
    public int $id;
    public string $imdbId;
    public string $knownForDepartment;
    public string $name;
    public string $placeOfBirth;
    public float $popularity;
    public ?string $profilePath;
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
