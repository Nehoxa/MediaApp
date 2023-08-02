<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\Tmdb\Facades\Tmdb;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    /**
     * Display a listing of movies and series.
     *
     * @return \Inertia\Response
     */
    public function home(): Response
    {
        $medias = Tmdb::mediasList();

        $genres = Cache::remember('genres', now()->addMinute(), fn () => Tmdb::genresList());

        return Inertia::render('HomePage', compact('medias', 'genres'));
    }

    /**
     * Display a listing of movies.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $movies = Cache::remember('movies', now()->addMinute(), fn () => Tmdb::moviesList());

        $genres = Cache::remember('genres', now()->addMinute(), fn () => Tmdb::genresList());

        return Inertia::render('Movie/MovieHomePage', compact('movies', 'genres'));
    }

    /**
     * Display the specified Movie.
     *
     * @param integer $id
     * @return \Inertia\Response
     */
    public function show(int $id): Response
    {
        $movie = Cache::remember('movie' . $id, now()->addSeconds(2), fn () => Tmdb::showMovie($id));

        $credits = Cache::remember('credit' . $id, now()->addMinute(), fn () => Tmdb::movieCredit($id));

        $relatedMovies = Cache::remember('relatedMovies' . $id, now()->addMinute(), fn () => Tmdb::movieRelated($id));

        return Inertia::render('Movie/Show', compact('movie', 'credits', 'relatedMovies'));
    }

    /**
     * Display the specified Saga.
     *
     * @param integer $id
     * @return \Inertia\Response
     */
    public function showCollection(int $id): Response
    {
        $collection = Cache::remember('collection' . $id, now()->addSeconds(2), fn () => Tmdb::movieCollection($id));

        return Inertia::render('Movie/Collection', compact('collection'));
    }
}
