<?php

namespace App\Http\Controllers;

use App\Services\Tmdb\Facades\Tmdb;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class PersonController extends Controller
{
    /**
     * Display the specified person.
     *
     * @param integer $id
     * @return \Inertia\Response
     */
    public function show(int $id): Response
    {
        $person = Cache::remember('show' . $id, now()->addMinute(), fn () => Tmdb::showPerson($id));

        $combinedCredit = Tmdb::creditsPerson($id);

        $allMedia = Cache::remember('allMedia' . $id, now()->addMinute(), fn () => Tmdb::sortBioPerson($id));

        return Inertia::render('Person/ShowPerson', compact('person', 'allMedia'));
    }
}
