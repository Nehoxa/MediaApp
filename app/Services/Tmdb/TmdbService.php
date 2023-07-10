<?php

namespace App\Services\Tmdb;

use Inertia\Inertia;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class TmdbService
{
    public function __construct(protected array $config)
    {
    }

    protected function get(string $uri, array $params = []): Response
    {
        $params = array_merge($params, [
            'api_key' => $this->config['api_key'],
            'language' => $this->config['language'],
        ]);

        $response = Http::get($this->config['endpoint'] . $uri, $params);

        return $response;
    }

    public function checkResponse(array $response)
    {
        $statusMessage = null;
        if (array_key_exists('status_message', $response)) {
            $statusMessage = $response['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }
    }

    public function multiSearch(string $query, int $page): mixed
    {
        return $this->get('search/multi', ['query' => $query, 'page' => $page])->json();
    }

    public function movieSearch(string $query, int $page): mixed
    {
        return $this->get('search/movie', ['query' => $query, 'page' => $page])->json();
    }

    public function serieSearch(string $query, int $page): mixed
    {
        return $this->get('search/tv', ['query' => $query, 'page' => $page])->json();
    }

    public function personSearch(string $query, int $page): mixed
    {
        return $this->get('search/person', ['query' => $query, 'page' => $page])->json();
    }

    public function mediasList(): mixed
    {
        return $this->get('trending/all/week')->json();
    }

    public function moviesList(): mixed
    {
        return $this->get('trending/movie/week')->json();
    }

    public function seriesList(): mixed
    {
        return $this->get('trending/tv/week')->json();
    }

    public function genresList(): mixed
    {
        return $this->get('genre/movie/list')->json();
    }

    public function showMovie(int $paged): mixed
    {
        return $this->get('movie/' . $paged)->json();
    }

    public function showSerie(int $paged): mixed
    {
        return $this->get('tv/' . $paged)->json();
    }

    public function showPerson(int $paged): mixed
    {
        return $this->get('person/' . $paged)->json();
    }

    public function movieCredit(int $paged): mixed
    {
        return $this->get('movie/' . $paged . '/credits')->json();
    }

    public function serieCredit(int $paged): mixed
    {
        return $this->get('tv/' . $paged . '/credits')->json();
    }

    public function movieRelated(int $paged): mixed
    {
        return $this->get('movie/' . $paged . '/recommendations')->json();
    }

    public function serieRelated(int $paged): mixed
    {
        return $this->get('tv/' . $paged . '/recommendations')->json();
    }

    public function movieCollection(int $paged): mixed
    {
        return $this->get('collection/' . $paged)->json();
    }

    public function showSeason(int $paged, int $season): mixed
    {
        return $this->get('tv/' . $paged . '/season/' . $season)->json();
    }

    public function showEpisode(int $paged, int $season, int $episode): mixed
    {
        return $this->get('tv/' . $paged . '/season/' . $season . '/episode/' . $episode)->json();
    }

    public function creditsEpisode(int $paged, int $season, int $episode): mixed
    {
        return $this->get('tv/' . $paged . '/season/' . $season . '/episode/' . $episode . '/credits')->json();
    }

    public function creditsPerson($paged): mixed
    {
        return $this->get('person/' . $paged . '/combined_credits')->json();
    }

    public function paginate($results, string $query, string $mediaType): array
    {
        $links = [];

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            foreach(range(1, 3) as $page) {
                if($page === $results['page']) {
                    $links[$page]['active'] = true;
                } else {
                    $links[$page]['active'] = false;
                }
                $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                $links[$page]['label'] = $page;
            }

            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                foreach(range($results['page'] - 1, $results['page'] + 1) as $page) {
                    if($page === $results['page']) {
                        $links[$page]['active'] = true;
                    } else {
                        $links[$page]['active'] = false;
                    }
                    $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                    if ($results['page'] - 1) {
                    }
                    $links[$page]['label'] = $page;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            foreach(range($results['total_pages'] - 2, $results['total_pages']) as $page) {
                if($page === $results['page']) {
                    $links[$page]['active'] = true;
                } else {
                    $links[$page]['active'] = false;
                }
                $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                $links[$page]['label'] = $page;
            }

        } else {
            foreach(range(1, $results['total_pages']) as $page) {
                if($page === $results['page']) {
                    $links[$page]['active'] = true;
                } else {
                    $links[$page]['active'] = false;
                }
                $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                $links[$page]['label'] = $page;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

        return $links;
    }

    public function sort(array $array): array
    {
        usort($array, function ($firstDate, $secondDate) {
            $firstDate = isset($firstDate['release_date']) ? $firstDate['release_date'] : $firstDate['first_air_date'];
            $secondDate = isset($secondDate['release_date']) ? $secondDate['release_date'] : $secondDate['first_air_date'];
            return strcmp($secondDate, $firstDate);
        });

        return $array;
    }

    public function sortBioPerson($paged): array
    {
        $combinedCredit = $this->creditsPerson($paged);

        $cast = [];
        $directing = [];
        $production = [];
        $writing = [];
        $creator = [];

        $cast = $combinedCredit['cast'];

        $popularMedia = array_merge($combinedCredit['cast'], $combinedCredit['crew']);

        foreach ($combinedCredit['crew'] as $pagetem) {
            if (isset($pagetem['department'])) {
                if ($pagetem['department'] === 'Directing') {
                    $directing[] = $pagetem;
                }
                if ($pagetem['department'] === 'Production') {
                    $production[] = $pagetem;
                }
                if ($pagetem['department'] === 'Writing') {
                    $writing[] = $pagetem;
                }
                if ($pagetem['department'] === 'Creator') {
                    $creator[] = $pagetem;
                }
            }
        }

        $cast = $this->sort($cast);
        $directing = $this->sort($directing);
        $production = $this->sort($production);
        $writing = $this->sort($writing);
        $creator = $this->sort($creator);

        usort($popularMedia, function ($firstMedia, $secondMedia) {
            return $secondMedia['vote_count'] - $firstMedia['vote_count'];
        });

        $allMedia['cast'] = $cast;
        $allMedia['directing'] = $directing;
        $allMedia['production'] = $production;
        $allMedia['writing'] = $writing;
        $allMedia['creator'] = $creator;
        $allMedia['popularMedia'] = array_slice($popularMedia, 0, 20);

        return $allMedia;
    }
}
