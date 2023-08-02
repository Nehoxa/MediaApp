<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\Tmdb\Facades\Tmdb;
use Illuminate\Support\Facades\Cache;

class SerieTvController extends Controller
{
    /**
     * Display a listing of series.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $series = Tmdb::seriesList();

        $genres = Cache::remember('genres', now()->addMinute(), fn () => Tmdb::genresList());

        return Inertia::render('SerieTv/SeriesHomePage', compact('series', 'genres'));
    }

    /**
     * Display the specified serie.
     *
     * @param integer $id
     * @return \Inertia\Response
     */
    public function show(int $id): Response
    {
        $serie = Cache::remember('serie' . $id, now()->addMinute(), fn () => Tmdb::showSerie($id));

        $credits = Cache::remember('credits' . $id, now()->addMinute(), fn () => Tmdb::serieCredit($id));

        $recommendations = Cache::remember('recommendations' . $id, now()->addMinute(), fn () => Tmdb::serieRelated($id));

        return Inertia::render('SerieTv/Show', compact('serie', 'credits', 'recommendations'));
    }

    /**
     * Display the specified season of serie.
     *
     * @param integer $id
     * @param integer $season
     * @return \Inertia\Response
     */
    public function showSeason(int $id, int $season): Response
    {
        $season = Cache::remember('serie' . $id . 'season' . $season, now()->addMinute(), fn () => Tmdb::showSeason($id, $season));

        return Inertia::render('SerieTv/ShowSeason', compact('season', ));
    }

    /**
     * Display the specified episode of serie.
     *
     * @param integer $id
     * @param integer $season
     * @param integer $nbEpisode
     * @return \Inertia\Response
     */
    public function showEpisode(int $id, int $season, int $nbEpisode)
    {
        $episode = Cache::remember('serie' . $id . 'season' . $season . 'epsiode' . $nbEpisode, now()->addMinute(), fn () => Tmdb::showEpisode($id, $season, $nbEpisode));

        $credits = Cache::remember('credits' . $id . 'season' . $season . 'epsiode' . $nbEpisode, now()->addMinute(), fn () => Tmdb::creditsEpisode($id, $season, $nbEpisode));

        return Inertia::render('SerieTv/ShowEpisode', compact('episode', 'credits'));
    }
}
