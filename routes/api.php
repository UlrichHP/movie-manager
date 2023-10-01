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

Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{id}/show', [MovieController::class, 'show']);
});

Route::prefix('genres')->group(function () {
    Route::get('/', [GenreController::class, 'index']);
    Route::get('/{genre}/show', [GenreController::class, 'show']);
});

Route::prefix('actors')->group(function () {
    Route::get('/', [ActorController::class, 'index']);
    Route::get('/{actor}/show', [ActorController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('movies')->group(function () {
        Route::post('/create', [MovieController::class, 'store']);
        Route::put('/{id}/edit', [MovieController::class, 'update']);
        Route::delete('/{movie}/delete', [MovieController::class, 'destroy']);
    });

    Route::prefix('genres')->group(function () {
        Route::post('/create', [GenreController::class, 'store']);
        Route::put('/{genre}/edit', [GenreController::class, 'update']);
        Route::delete('/{genre}/delete', [GenreController::class, 'destroy']);
    });

    Route::prefix('actors')->group(function () {
        Route::post('/create', [ActorController::class, 'store']);
        Route::put('/{actor}/edit', [ActorController::class, 'update']);
        Route::delete('/{actor}/delete', [ActorController::class, 'destroy']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
