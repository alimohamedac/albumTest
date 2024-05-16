<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PictureController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('albums', AlbumController::class);
    Route::resource('pictures', PictureController::class);

    Route::post('albums/{album}/deleteOrMove', [AlbumController::class, 'deleteOrMove'])->name('albums.deleteOrMove');
});

//Route::get('/home', 'HomeController@index')->name('home');
