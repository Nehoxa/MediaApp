<?php

namespace App\Services\Tmdb\Entities;

use Illuminate\Http\Client\Response;

class SearchEntities
{
    public int $statusCode;
    public string $statusMessage;

    public function __construct(Response $data, string $query)
    {        
        $collection = collect((array) $data->json());

        if ($data->status() === 200) {
            foreach ($collection as $key => $value) {
                $camelCaseKey = str($key)->camel();
                $this->$camelCaseKey = $collection->get($key);
            }
            $this->query =  $query;
            $this->statusCode = $data->status();
            $this->statusMessage = $data->reason();
        } else {
            $this->statusCode = $data->status();
            $this->statusMessage = $collection->get('status_message');
        }

    }
}
