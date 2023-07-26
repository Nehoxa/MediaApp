<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\Tmdb\Facades\Tmdb;
use Inertia\Response;

class SearchController extends Controller
{
    /**
     * Display a list of mixed media matching with query
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function search(Request $request): Response
    {
        $query = $request->search;

        $results = Tmdb::multiSearch($query, $request->page);

        $data['search'] = $query;
        $data['page'] = 1;

        $links = Tmdb::paginate($results, $query, 'multi');

        return Inertia::render('Search/Index', compact('results', 'links', 'data'));
    }

    /**
     * Display a list of movie matching with query
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function searchMovie(Request $request): Response
    {
        $query = $request->search;

        $results = Tmdb::movieSearch($query, $request->page);


        $data['search'] = $query;
        $data['page'] = 1;

        $links = Tmdb::paginate($results, $query, 'movie');

        return Inertia::render('Search/Movie', compact('results', 'links', 'data'));
    }

    /**
     * Display a list of serie matching with query
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function searchSerie(Request $request): Response
    {
        $query = $request->search;

        $results = Tmdb::serieSearch($query, $request->page);

        $data['search'] = $query;
        $data['page'] = 1;

        $links = Tmdb::paginate($results, $query, 'serie');

        return Inertia::render('Search/Serie', compact('results', 'links', 'data'));
    }

    /**
     * Display a list of person matching with query
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function searchPerson(Request $request): Response
    {
        $query = $request->search;

        $results = Tmdb::personSearch($query, $request->page);

        $data['search'] = $query;
        $data['page'] = 1;

        $links = Tmdb::paginate($results, $query, 'person');

        return Inertia::render('Search/Person', compact('results', 'links', 'data'));
    }
}
