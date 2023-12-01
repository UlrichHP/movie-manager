<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'movie.index');
Route::view('/movies/{movie}', 'movie.show');

Route::view('/actors', 'actor.index');
Route::view('/actors/{actor}', 'actor.show');

Route::view('/genres', 'genre.index');
Route::view('/genres/{genre}', 'genre.show');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
