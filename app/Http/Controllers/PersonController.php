<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified person.
     */
    public function show(int $id)
    {
        $api_key = '?api_key=' . config('tmdb.api_key');
        $language = config('tmdb.language');
        $endpoint = config('tmdb.endpoint');

        $person = Http::get($endpoint . 'person/' . $id . $api_key . $language)->json();

        $statusMessage = null;
        if (array_key_exists('status_message', $person)) {
            $statusMessage = $person['status_message'];
        }

        $cast = array();
        $directing = array();
        $production = array();
        $writing = array();
        $creator = array();
        $addedMedia = array();
        $popularMedia =  array();

        if (!$statusMessage) {
            $combinedCredit = Http::get($endpoint . 'person/' . $id . '/combined_credits' . $api_key . $language)->json();
    
            $cast = $combinedCredit['cast'];
    
            $allMedia = array_merge($combinedCredit['cast'], $combinedCredit['crew']);
    
    
            foreach ($combinedCredit['crew'] as $item) {
                if (isset($item['department'])) {
                    if ($item['department'] === 'Directing') {
                        $directing[] = $item;
                    }
                    if ($item['department'] === 'Production') {
                        $production[] = $item;
                    }
                    if ($item['department'] === 'Writing') {
                        $writing[] = $item;
                    }
                    if ($item['department'] === 'Creator') {
                        $creator[] = $item;
                    }
                }
            }
    
            usort($cast, function ($a, $b) {
                $dateA = isset($a['release_date']) ? $a['release_date'] : $a['first_air_date'];
                $dateB = isset($b['release_date']) ? $b['release_date'] : $b['first_air_date'];
                return strcmp($dateB, $dateA);
            });
    
            usort($directing, function ($a, $b) {
                $dateA = isset($a['release_date']) ? $a['release_date'] : $a['first_air_date'];
                $dateB = isset($b['release_date']) ? $b['release_date'] : $b['first_air_date'];
                return strcmp($dateB, $dateA);
            });
    
            usort($production, function ($a, $b) {
                $dateA = isset($a['release_date']) ? $a['release_date'] : $a['first_air_date'];
                $dateB = isset($b['release_date']) ? $b['release_date'] : $b['first_air_date'];
                return strcmp($dateB, $dateA);
            });
    
            usort($writing, function ($a, $b) {
                $dateA = isset($a['release_date']) ? $a['release_date'] : $a['first_air_date'];
                $dateB = isset($b['release_date']) ? $b['release_date'] : $b['first_air_date'];
                return strcmp($dateB, $dateA);
            });
    
            usort($creator, function ($a, $b) {
                $dateA = isset($a['release_date']) ? $a['release_date'] : $a['first_air_date'];
                $dateB = isset($b['release_date']) ? $b['release_date'] : $b['first_air_date'];
                return strcmp($dateB, $dateA);
            });

            foreach ($allMedia as $media) {
                if ($media['vote_count'] >= 500 && $media['vote_average'] >= 5 && !in_array($media['id'], $addedMedia)) {
                    $popularMedia[] = $media;
                    $addedMedia[] = $media['id']; // Ajoute l'ID du média au tableau des médias déjà ajoutés
                }
            }
    
            usort($popularMedia, function ($a, $b) {
                return $b['vote_count'] - $a['vote_count'];
            });
        }

        return Inertia::render('Person/ShowPerson', compact('person', 'popularMedia', 'cast', 'directing', 'production', 'writing', 'creator', 'statusMessage'));
    }
}
