<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
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

Route::get('/', [MovieController::class, 'index']);
Route::get('/movies/{movie}', [MovieController::class, 'show']);

Route::get('/actors', [ActorController::class, 'index']);
Route::get('/actors/{actor}', [ActorController::class, 'show']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

Route::get('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register']);
