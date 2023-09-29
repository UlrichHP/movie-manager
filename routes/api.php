<?php

use App\Http\Controllers\Api\ActorController;
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

Route::group([
    'prefix' => 'movies',
], function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{movie}/show', [MovieController::class, 'show']);
    Route::post('/create', [MovieController::class, 'store']);
    Route::put('/{movie}/edit', [MovieController::class, 'update']);
    Route::delete('/{movie}/delete', [MovieController::class, 'destroy']);
});

Route::group([
    'prefix' => 'genres',
], function () {
    Route::get('/', [GenreController::class, 'index']);
    Route::get('/{genre}/show', [GenreController::class, 'show']);
    Route::post('/create', [GenreController::class, 'store']);
    Route::put('/{genre}/edit', [GenreController::class, 'update']);
    Route::delete('/{genre}/delete', [GenreController::class, 'destroy']);
});

Route::group([
    'prefix' => 'actors',
], function () {
    Route::get('/', [ActorController::class, 'index']);
    Route::get('/{actor}/show', [ActorController::class, 'show']);
    Route::post('/create', [ActorController::class, 'store']);
    Route::put('/{actor}/edit', [ActorController::class, 'update']);
    Route::delete('/{actor}/delete', [ActorController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
