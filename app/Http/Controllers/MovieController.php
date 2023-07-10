<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\Tmdb\Facades\Tmdb;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    /**
     * Display a listing of movie and serie.
     *
     * @return \Inertia\Response
     */
    public function home(): Response
    {
        $medias = Tmdb::mediasList();

        $statusMessage = null;
        if (array_key_exists('status_message', $medias)) {
            $statusMessage = $medias['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        $genres = Cache::remember('genres', now()->addMinute(), function () {
            return Tmdb::genresList();
        });

        return Inertia::render('HomePage', compact('medias', 'genres'));
    }

    /**
     * Display a listing of movie.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $movies = Cache::remember('movies', now()->addMinute(), function () {
            return Tmdb::moviesList();
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $movies)) {
            $statusMessage = $movies['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        $genres = Cache::remember('genres', now()->addMinute(), function () {
            return Tmdb::genresList();
        });

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
        $movie = Cache::remember('movie' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::showMovie($id);
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $movie)) {
            $statusMessage = $movie['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        $credits = Cache::remember('credit' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::movieCredit($id);
        });

        $relatedMovies = Cache::remember('relatedMovies' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::movieRelated($id);
        });

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
        $collection = Cache::remember('collection' . $id, now()->addMinute(), function () use ($id) {
            $collection = Tmdb::movieCollection($id);

            $statusMessage = null;
            if (array_key_exists('status_message', $collection)) {
                $statusMessage = $collection['status_message'];
                return Inertia::render('Error/Error', compact('statusMessage'));
            }
    
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

            return $collection;
        });

        return Inertia::render('Movie/Collection', compact('collection'));
    }
}
