<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->search;
        $page = $request->page;

        $api_key = '&api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        if ($page === null) {
            $page = 1;
        }

        $results = Http::get($endpoint . 'search/multi?query=' . $query . '&include_adult=false' . $api_key . $language . '&page=' . $page)->json();

        $data['search'] = $query;
        $data['page'] = 1;

        $links = array();

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            for ($i = 1; $i <= 3; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                for ($i = $results['page'] - 1 ; $i <= $results['page'] + 1; $i++) {
                    if($i === $results['page']) {
                        $links[$i]['active'] = true;
                    } else {
                        $links[$i]['active'] = false;
                    }
                    $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                    if ($results['page'] - 1) {
                    }
                    $links[$i]['label'] = $i;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            for ($i = $results['total_pages'] - 2 ; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

        } else {
            for ($i = 1; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

        return Inertia::render('Search/Index', compact('results', 'links', 'data'));
    }

    public function searchMovie(Request $request)
    {
        $query = $request->search;
        $page = $request->page;

        $api_key = '&api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        if ($page === null) {
            $page = 1;
        }

        $results = Http::get($endpoint . 'search/movie?query=' . $query . '&include_adult=false' . $api_key . $language . '&page=' . $page)->json();

        $data['search'] = $query;
        $data['page'] = 1;

        $links = array();

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            for ($i = 1; $i <= 3; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }


            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                for ($i = $results['page'] - 1 ; $i <= $results['page'] + 1; $i++) {
                    if($i === $results['page']) {
                        $links[$i]['active'] = true;
                    } else {
                        $links[$i]['active'] = false;
                    }
                    $links[$i]['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $i;
                    if ($results['page'] - 1) {
                    }
                    $links[$i]['label'] = $i;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            for ($i = $results['total_pages'] - 2 ; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

        } else {
            for ($i = 1; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search/movie?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

        return Inertia::render('Search/Movie', compact('results', 'links', 'data'));
    }

    public function searchSerie(Request $request)
    {
        $query = $request->search;
        $page = $request->page;

        $api_key = '&api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $results = Http::get($endpoint . 'search/tv?query=' . $query . '&include_adult=false' . $api_key . $language . '&page=' . $page)->json();

        $data['search'] = $query;
        $data['page'] = 1;

        $links = array();

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            for ($i = 1; $i <= 3; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }


            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                for ($i = $results['page'] - 1 ; $i <= $results['page'] + 1; $i++) {
                    if($i === $results['page']) {
                        $links[$i]['active'] = true;
                    } else {
                        $links[$i]['active'] = false;
                    }
                    $links[$i]['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $i;
                    if ($results['page'] - 1) {
                    }
                    $links[$i]['label'] = $i;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            for ($i = $results['total_pages'] - 2 ; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

        } else {
            for ($i = 1; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search/serie?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

        return Inertia::render('Search/Serie', compact('results', 'links', 'data'));
    }

    public function searchPerson(Request $request)
    {
        $query = $request->search;
        $page = $request->page;

        $api_key = '&api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $results = Http::get($endpoint . 'search/person?query=' . $query . '&include_adult=false' . $api_key . $language . '&page=' . $page)->json();

        $data['search'] = $query;
        $data['page'] = 1;

        $links = array();

        $links['0']['active'] = false;
        $links['0']['label'] = '&laquo; Précédent';
        $links['0']['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $results['page'] - 1;
        if($results['page'] - 1 === 0) {
            $links['0']['url'] = null;
        }
        if ($results['total_pages'] > 20) {
            for ($i = 1; $i <= 3; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }


            $links['4']['active'] = false;
            $links['4']['label'] = '...';
            $links['4']['url'] = null;

            if ($results['page'] != 1) {
                for ($i = $results['page'] - 1 ; $i <= $results['page'] + 1; $i++) {
                    if($i === $results['page']) {
                        $links[$i]['active'] = true;
                    } else {
                        $links[$i]['active'] = false;
                    }
                    $links[$i]['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $i;
                    if ($results['page'] - 1) {
                    }
                    $links[$i]['label'] = $i;
                }
            }

            if ($results['page'] >= 3 && $results['page'] < $results['total_pages'] - 4) {
                $links[$results['total_pages'] - 3]['active'] = false;
                $links[$results['total_pages'] - 3]['label'] = '...';
                $links[$results['total_pages'] - 3]['url'] = null;
            }

            for ($i = $results['total_pages'] - 2 ; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }

        } else {
            for ($i = 1; $i <= $results['total_pages']; $i++) {
                if($i === $results['page']) {
                    $links[$i]['active'] = true;
                } else {
                    $links[$i]['active'] = false;
                }
                $links[$i]['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $i;
                $links[$i]['label'] = $i;
            }
        }
        $links[$results['total_pages'] + 1]['active'] = false;
        $links[$results['total_pages'] + 1]['label'] = 'Suivant &raquo;';
        $links[$results['total_pages'] + 1]['url'] = 'http://filmapp.test/search/person?search=' . $query . '&page=' . $results['page'] + 1;
        if($results['page'] + 1 > $results['total_pages']) {
            $links[$results['total_pages'] + 1]['url'] = null;
        }

        return Inertia::render('Search/Person', compact('results', 'links', 'data'));
    }
}
