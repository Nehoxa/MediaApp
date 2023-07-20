<?php

namespace App\Services\Tmdb\Entities;

class RelatedMedia
{
    public int $page;
    public ?array $results;
    public int $totalPages;
    public int $totalResults;
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
