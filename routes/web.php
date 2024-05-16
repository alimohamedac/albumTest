<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PictureController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::get('/albums/{album}/edit', [AlbumController::class, 'edit'])->name('albums.edit');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');

   // Route::get('/pictures', [PictureController::class, 'index'])->name('pictures.index');
    //Route::get('/pictures/create', [PictureController::class, 'create'])->name('pictures.create');
    Route::post('/pictures', [AlbumController::class, 'store'])->name('pictures.store');
    //Route::get('/pictures/{picture}', [AlbumController::class, 'show'])->name('pictures.show');
    //Route::get('/pictures/{picture}/edit', [AlbumController::class, 'edit'])->name('pictures.edit');
    //Route::put('/pictures/{picture}', [AlbumController::class, 'update'])->name('pictures.update');
    //Route::delete('/pictures/{picture}', [AlbumController::class, 'destroy'])->name('pictures.destroy');

    Route::post('albums/{album}/deleteOrMove', [AlbumController::class, 'deleteOrMove'])->name('albums.deleteOrMove');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
