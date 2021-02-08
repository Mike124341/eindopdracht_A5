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
Route::get('bands', 'App\Http\Controllers\BandsViewController@index')->name('bands');;
Route::get('bands/{id}', 'App\Http\Controllers\EPK_Template_controller@index')->where('id', '[0-9]+');
Route::post('search', 'App\Http\Controllers\SearchController@index');
Route::fallback(function () {
  return view('welcome');
});

Route::group(['middleware' => ['auth']], function() {
    #password veranderen
    Route::post('passupdate', 'App\Http\Controllers\Pop_upController@changePassword');
    Route::post('join-band-request', 'App\Http\Controllers\Pop_upController@sent_band_request');
    Route::post('/process', 'App\Http\Controllers\BandController@process');
    Route::post('/new-band', 'App\Http\Controllers\BandController@createBand');
    Route::get('/verzoeken', 'App\Http\Controllers\VerzoekenController@index')->name('verzoeken');
    Route::post('/cssupdate', 'App\Http\Controllers\Pop_upController@updateColor');
    Route::post('/changemedia', 'App\Http\Controllers\MediaController@changeMedia');
  });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
