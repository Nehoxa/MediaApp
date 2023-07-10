<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Services\Tmdb\Facades\Tmdb;
use Illuminate\Support\Facades\Cache;

class SerieTvController extends Controller
{
    /**
     * Display a listing of serie.
     * 
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        $series = Tmdb::seriesList();

        $genres = Cache::remember('genres', now()->addMinute(), function () {
            return Tmdb::genresList();
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $series)) {
            $statusMessage = $series['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

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
        $serie = Cache::remember('serie' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::showSerie($id);
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $serie)) {
            $statusMessage = $serie['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        $credits = Cache::remember('credits' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::serieCredit($id);
        });
        $recommendations = Cache::remember('recommendations' . $id, now()->addMinute(), function () use ($id) {
            return Tmdb::serieRelated($id);
        });

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
        $season = Cache::remember('serie' . $id . 'season' . $season, now()->addMinute(), function () use ($id, $season) {
            return Tmdb::showSeason($id, $season);
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $season)) {
            $statusMessage = $season['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        return Inertia::render('SerieTv/ShowSeason', compact('season', ));
    }

    public function showEpisode(int $id, int $season, int $nbEpisode)
    {
        $episode = Cache::remember('serie' . $id . 'season' . $season . 'epsiode' . $nbEpisode , now()->addMinute(), function () use ($id, $season, $nbEpisode) {
            return Tmdb::showEpisode($id, $season, $nbEpisode);
        });

        $credits = Cache::remember('credits' . $id . 'season' . $season . 'epsiode' . $nbEpisode , now()->addMinute(), function () use ($id, $season, $nbEpisode) {
            return Tmdb::creditsEpisode($id, $season, $nbEpisode);
        });

        $statusMessage = null;
        if (array_key_exists('status_message', $episode)) {
            $statusMessage = $episode['status_message'];
            return Inertia::render('Error/Error', compact('statusMessage'));
        }

        return Inertia::render('SerieTv/ShowEpisode', compact('episode', 'credits'));
    }
}
