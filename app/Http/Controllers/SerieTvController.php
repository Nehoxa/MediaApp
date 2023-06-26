<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SerieTvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $api_key = config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $genres = Http::get($endpoint . 'genre/tv/list' . '?api_key=' . $api_key . $language)->json();

        $series = Http::get($endpoint . 'trending/tv/week' . '?api_key=' . $api_key . $language)->json();

        return Inertia::render('SerieTv/SeriesHomePage', compact('series', 'genres'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $serie = Http::get($endpoint . 'tv/' . $id . $api_key . $language)->json();

        $statusMessage = null;
        if (array_key_exists('status_message', $serie)) {
            $statusMessage = $serie['status_message'];
        }

        $credits = Http::get($endpoint . 'tv/' . $id . '/credits' . $api_key . $language)->json();

        $recommendations = Http::get($endpoint . 'tv/' . $id . '/recommendations' . $api_key . $language)->json();

        return Inertia::render('SerieTv/Show', compact('serie', 'credits', 'recommendations', 'statusMessage'));
    }

    public function showSeason(int $id, int $season)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $season = Http::get($endpoint . 'tv/' . $id . '/season/' . $season . $api_key . $language)->json();

        return Inertia::render('SerieTv/ShowSeason', compact('season', ));
    }

    public function showEpisode(int $id, int $season, int $episode)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $credits = Http::get($endpoint . 'tv/' . $id . '/season/' . $season . '/episode/' . $episode . '/credits' . $api_key . $language)->json();
        $episode = Http::get($endpoint . 'tv/' . $id . '/season/' . $season . '/episode/' . $episode . $api_key . $language)->json();

        return Inertia::render('SerieTv/ShowEpisode', compact('episode', 'credits'));
    }

    public function search(String $search)
    {
        // $search = $request->search;

        $api_key = '&api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $results = Http::get($endpoint . 'search/tv?query=' . $search . '&include_adult=false' . $api_key . $language)->json();

        return Inertia::render('Search/Index', compact('results'));
    }
}
