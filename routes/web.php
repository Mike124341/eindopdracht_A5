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

Route::group(['middleware' => ['auth']], function() {
    #password veranderen
    Route::post('passupdate', 'App\Http\Controllers\Pop_upController@changePassword');
    Route::post('join-band-request', 'App\Http\Controllers\Pop_upController@sent_band_request');

  });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
