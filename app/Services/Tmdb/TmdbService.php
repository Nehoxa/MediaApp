<?php

namespace App\Services\Tmdb;

use Inertia\Inertia;
use App\Enums\Department;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use App\Services\Tmdb\Entities\Movie;
use App\Services\Tmdb\Entities\Serie;
use App\Services\Tmdb\Entities\Person;
use App\Services\Tmdb\Entities\GenreList;
use App\Services\Tmdb\Entities\MediaList;
use App\Services\Tmdb\Entities\MovieList;
use App\Services\Tmdb\Entities\SerieList;
use App\Services\Tmdb\Entities\MediaCredit;
use App\Services\Tmdb\Entities\MovieSearch;
use App\Services\Tmdb\Entities\MultiSearch;
use App\Services\Tmdb\Entities\SeasonSerie;
use App\Services\Tmdb\Entities\SerieSearch;
use App\Services\Tmdb\Entities\EpisodeSerie;
use App\Services\Tmdb\Entities\PersonCredit;
use App\Services\Tmdb\Entities\PersonSearch;
use App\Services\Tmdb\Entities\RelatedMedia;
use App\Services\Tmdb\Entities\EpisodeCredit;
use App\Services\Tmdb\Entities\MovieCollection;

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

    /**
     * Display a list of mixed media matching with query
     *
     * @param string $query
     * @param int $page
     * @return object
     */
    public function multiSearch(string $query, int $page): Object
    {
        return new MultiSearch($this->get('search/multi', ['query' => $query, 'page' => $page]));
    }

    /**
     * Display a list of movie matching with query
     *
     * @param string $query
     * @param int $page
     * @return object
     */
    public function movieSearch(string $query, int $page): Object
    {
        return new MovieSearch($this->get('search/movie', ['query' => $query, 'page' => $page]));
    }

    /**
     * Display a list of serie matching with query
     *
     * @param string $query
     * @param int $page
     * @return object
     */
    public function serieSearch(string $query, int $page): Object
    {
        return new SerieSearch($this->get('search/tv', ['query' => $query, 'page' => $page]));
    }

    /**
     * Display a list of person matching with query
     *
     * @param string $query
     * @param int $page
     * @return object
     */
    public function personSearch(string $query, int $page): Object
    {
        return new PersonSearch($this->get('search/person', ['query' => $query, 'page' => $page]));
    }

    /**
     * Display a listing of movies and series.
     *
     * @return object
     */
    public function mediasList(): Object
    {
        return new MediaList($this->get('trending/all/week'));
    }

    /**
     * Display a listing of movies.
     *
     * @return object
     */
    public function moviesList(): Object
    {
        return new MovieList($this->get('trending/movie/week'));
    }

    /**
     * Display a listing of series.
     *
     * @return object
     */
    public function seriesList(): Object
    {
        return new SerieList($this->get('trending/tv/week'));
    }

    /**
     * Display a listing of genres.
     *
     * @return object
     */
    public function genresList(): Object
    {
        return new GenreList($this->get('genre/movie/list'));
    }

    /**
     * Display the specified Movie.
     *
     * @param integer $id
     * @return object
     */
    public function showMovie(int $id): Object
    {
        return new Movie($this->get('movie/' . $id));
    }

    /**
     * Display the specified Serie.
     *
     * @param integer $id
     * @return object
     */
    public function showSerie(int $id): Object
    {
        // dd($this->get('tv/' . $id)->json());
        return new Serie($this->get('tv/' . $id));
    }

    /**
     * Display the specified Person.
     *
     * @param integer $id
     * @return object
     */
    public function showPerson(int $id): Object
    {
        return new Person($this->get('person/' . $id));
    }

    /**
     * Display the credits of specified Movie.
     *
     * @param integer $id
     * @return object
     */
    public function movieCredit(int $id): Object
    {
        return new MediaCredit($this->get('movie/' . $id . '/credits'));
    }

    /**
     * Display the credits of specified Serie.
     *
     * @param integer $id
     * @return object
     */
    public function serieCredit(int $id): Object
    {
        return new MediaCredit($this->get('tv/' . $id . '/credits'));
    }

    /**
     * Display the related movies of specified Movie.
     *
     * @param integer $id
     * @return object
     */
    public function movieRelated(int $id): Object
    {
        return new RelatedMedia($this->get('movie/' . $id . '/recommendations'));
    }

    /**
     * Display the related series of specified Serie.
     *
     * @param integer $id
     * @return object
     */
    public function serieRelated(int $id): Object
    {
        return new RelatedMedia($this->get('tv/' . $id . '/recommendations'));
    }

    /**
     * Display the collection of specified Movie.
     *
     * @param integer $id
     * @return object
     */
    public function movieCollection(int $id): Object
    {
        return new MovieCollection($this->get('collection/' . $id));
    }

    /**
     * Display the specified season of serie.
     *
     * @param integer $id
     * @param integer $season
     * @return object
     */
    public function showSeason(int $id, int $season): Object
    {
        return new SeasonSerie($this->get('tv/' . $id . '/season/' . $season));
    }

    /**
     * Display the specified episode of serie.
     *
     * @param integer $id
     * @param integer $season
     * @param integer $episode
     * @return object
     */
    public function showEpisode(int $id, int $season, int $episode): Object
    {
        return new EpisodeSerie($this->get('tv/' . $id . '/season/' . $season . '/episode/' . $episode));
    }

    /**
     * Display the credit of specified episode of serie.
     *
     * @param integer $id
     * @param integer $season
     * @param integer $episode
     * @return object
     */
    public function creditsEpisode(int $id, int $season, int $episode): mixed
    {
        return new EpisodeCredit($this->get('tv/' . $id . '/season/' . $season . '/episode/' . $episode . '/credits'));
    }

    /**
     * Display the credit of specified Person.
     *
     * @param integer $id
     * @param integer $season
     * @param integer $episode
     * @return object
     */
    public function creditsPerson($id): mixed
    {
        return new PersonCredit($this->get('person/' . $id . '/combined_credits'));
    }

    public function paginate($results, string $query, string $mediaType): array
    {
        $links = [];

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . ($results->page - 1);
        if($results->page - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results->totalPages > 20) {
            foreach(range(1, 3) as $page) {
                if($page === $results->page) {
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

            if ($results->page != 1) {
                foreach(range($results->page - 1, $results->page + 1) as $page) {
                    if($page === $results->page) {
                        $links[$page]['active'] = true;
                    } else {
                        $links[$page]['active'] = false;
                    }
                    $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                    if ($results->page - 1) {
                    }
                    $links[$page]['label'] = $page;
                }
            }

            if ($results->page >= 3 && $results->page < $results->totalPages - 4) {
                $links[$results->totalPages - 3]['active'] = false;
                $links[$results->totalPages - 3]['label'] = '...';
                $links[$results->totalPages - 3]['url'] = null;
            }

            foreach(range($results->totalPages - 2, $results->totalPages) as $page) {
                if($page === $results->page) {
                    $links[$page]['active'] = true;
                } else {
                    $links[$page]['active'] = false;
                }
                $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                $links[$page]['label'] = $page;
            }

        } else {
            foreach(range(1, $results->totalPages) as $page) {
                if($page === $results->page) {
                    $links[$page]['active'] = true;
                } else {
                    $links[$page]['active'] = false;
                }
                $links[$page]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . $page;
                $links[$page]['label'] = $page;
            }
        }
        $links[$results->totalPages + 1]['active'] = false;
        $links[$results->totalPages + 1]['label'] = 'Suivant &raquo;';
        $links[$results->totalPages + 1]['url'] = 'http://filmapp.test/search/' . $mediaType . '?search=' . $query . '&page=' . ($results->page + 1);
        if($results->page + 1 > $results->totalPages) {
            $links[$results->totalPages + 1]['url'] = null;
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

    public function sortBioPerson($id): array
    {
        $combinedCredit = $this->creditsPerson($id);

        $cast = [];
        $directing = [];
        $production = [];
        $writing = [];
        $creator = [];
        $crew = [];
        $otherProjects = [];

        $cast = $combinedCredit->cast;

        $popularMedia = array_merge($combinedCredit->cast, $combinedCredit->crew);

        foreach ($combinedCredit->crew as $project) {
            if (isset($project['department'])) {
                match($project['department']) {
                    Department::Directing->value => $directing[] = $project,
                    Department::Production->value => $production[] = $project,
                    Department::Writing->value => $writing[] = $project,
                    Department::Creator->value => $creator[] = $project,
                    Department::Crew->value => $crew[] = $project,
                    default => $otherProjects[] = $project,
                };
            }
        }

        usort($popularMedia, function ($firstMedia, $secondMedia) {
            return $secondMedia['vote_count'] - $firstMedia['vote_count'];
        });

        $allMedia['cast'] = $this->sort($cast);
        $allMedia['directing'] = $this->sort($directing);
        $allMedia['production'] = $this->sort($production);
        $allMedia['writing'] = $this->sort($writing);
        $allMedia['creator'] = $this->sort($creator);
        $allMedia['crew'] = $this->sort($crew);
        $allMedia['otherProjects'] = $this->sort($otherProjects);

        $allMedia['popularMedia'] = array_slice($popularMedia, 0, 20);

        return $allMedia;
    }
}
