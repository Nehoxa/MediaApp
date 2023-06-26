<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $genres = Http::get($endpoint . 'genre/movie/list' . $api_key . $language)->json();

        $medias = Http::get($endpoint . 'trending/all/week' . $api_key . $language)->json();

        return Inertia::render('HomePage', compact('medias', 'genres'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $genres = Http::get($endpoint . 'genre/movie/list' . $api_key . $language)->json();

        $movies = Http::get($endpoint . 'trending/movie/week' . $api_key . $language)->json();

        return Inertia::render('Movie/MovieHomePage', compact('movies', 'genres'));
    }

    /**
     * Display the specified Movie.
     */
    public function show(int $id)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $movie = Http::get($endpoint . 'movie/' . $id . $api_key . $language)->json();

        $statusMessage = null;
        if (array_key_exists('status_message', $movie)) {
            $statusMessage = $movie['status_message'];
        }

        $credits = Http::get($endpoint . 'movie/' . $id . '/credits' . $api_key . $language)->json();

        $relatedMovies = Http::get($endpoint . 'movie/' . $id . '/recommendations' . $api_key . $language)->json();

        return Inertia::render('Movie/Show', compact('movie', 'credits', 'relatedMovies', 'statusMessage'));
    }

    /**
     * Display the specified Saga.
     */
    public function showCollection(int $id)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $collection = Http::get($endpoint . 'collection/' . $id . $api_key . $language)->json();

        $movies = $collection['parts'];

        unset($collection['parts']);

        usort($movies, function ($a, $b) {
            $dateA = ($a['release_date'] !== '') ? $a['release_date'] : '9999-99-99';
            $dateB = ($b['release_date'] !== '') ? $b['release_date'] : '9999-99-99';

            if ($dateA == $dateB) {
                return 0;
            }

            return ($dateA < $dateB) ? -1 : 1;
        });

        $collection['parts'] = $movies;

        return Inertia::render('Movie/Collection', compact('collection'));
    }
}
