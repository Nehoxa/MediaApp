<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SerieTvController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MovieController::class, 'home'])->name('movie.home');

Route::get('/search/multi', [SearchController::class, 'search'])->name('search');
Route::get('/search/movie', [SearchController::class, 'searchMovie'])->name('search.movie');
Route::get('/search/serie', [SearchController::class, 'searchSerie'])->name('search.serie');
Route::get('/search/person', [SearchController::class, 'searchPerson'])->name('search.person');

Route::get('/movie', [MovieController::class, 'index'])->name('movie.index');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');
Route::get('/movie/collection/{id}', [MovieController::class, 'showCollection'])->name('movie.showCollection');

Route::get('/person/{id}', [PersonController::class, 'show'])->name('person.show');

Route::get('/serie', [SerieTvController::class, 'index'])->name('serie.index');
Route::get('/serie/{id}', [SerieTvController::class, 'show'])->name('serie.show');
Route::get('/serie/{id}/{season}', [SerieTvController::class, 'showSeason'])->name('serie.showSeason');
Route::get('/serie/{id}/{season}/{episode}', [SerieTvController::class, 'showEpisode'])->name('serie.showEpisode');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
