<?php

use App\Http\Controllers\Api\ActorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('movies')->as('movies.')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('index');
    Route::get('/{movie}/show', [MovieController::class, 'show'])->name('show');
});

Route::prefix('genres')->as('genres.')->group(function () {
    Route::get('/', [GenreController::class, 'index'])->name('index');
    Route::get('/{genre}/show', [GenreController::class, 'show'])->name('show');
});

Route::prefix('actors')->as('actors.')->group(function () {
    Route::get('/', [ActorController::class, 'index'])->name('index');
    Route::get('/{actor}/show', [ActorController::class, 'show'])->name('show');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('movies')->as('movies.')->group(function () {
        Route::post('/create', [MovieController::class, 'store'])->name('store');
        Route::put('/{movie}/edit', [MovieController::class, 'update'])->name('update');
        Route::delete('/{movie}/delete', [MovieController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('genres')->as('genres.')->group(function () {
        Route::post('/create', [GenreController::class, 'store'])->name('store');
        Route::put('/{genre}/edit', [GenreController::class, 'update'])->name('update');
        Route::delete('/{genre}/delete', [GenreController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('actors')->as('actors.')->group(function () {
        Route::post('/create', [ActorController::class, 'store'])->name('store');
        Route::put('/{actor}/edit', [ActorController::class, 'update'])->name('update');
        Route::delete('/{actor}/delete', [ActorController::class, 'destroy'])->name('destroy');
    });
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
