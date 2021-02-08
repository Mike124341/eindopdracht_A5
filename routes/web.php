<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
#bands
Route::get('bands', 'App\Http\Controllers\BandsViewController@index')->name('bands');;

#Band Template Met de bijbehoorende ID
Route::get('bands/{id}', 'App\Http\Controllers\EPK_Template_controller@index')->where('id', '[0-9]+');

#Zoek Functie
Route::post('search', 'App\Http\Controllers\SearchController@index');

#Voor als je een niet bestaande route zet in de URL
Route::fallback(function () {
  return view('welcome');
});

#Alle links waarvoor je ingelogd moet zijn
Route::group(['middleware' => ['auth']], function() {

    #Dashboard Links
    Route::post('passupdate', 'App\Http\Controllers\Pop_upController@changePassword');
    Route::post('email-update', 'App\Http\Controllers\Pop_upController@changeEmail');
    Route::post('name-update', 'App\Http\Controllers\Pop_upController@changeName');

    #Band Verzoeken / Requestss (Dashboard)
    Route::post('join-band-request', 'App\Http\Controllers\VerzoekenController@sent_band_request');
    Route::post('/process', 'App\Http\Controllers\VerzoekenController@process');
    Route::get('/verzoeken', 'App\Http\Controllers\VerzoekenController@index')->name('verzoeken');

    #Band Gegevens  (Dashboard)
    Route::post('/new-band', 'App\Http\Controllers\BandController@createBand');
    Route::post('/delete-band', 'App\Http\Controllers\BandController@deleteBand');
    Route::post('/cssupdate', 'App\Http\Controllers\BandController@updateColor');

    #Band Template Links
    Route::post('/changemedia', 'App\Http\Controllers\MediaController@changeMedia');
    Route::post('/genres', 'App\Http\Controllers\GenreController@changeGenre');

  });

#home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
