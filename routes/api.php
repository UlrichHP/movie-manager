<?php

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

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{movie}/show', [MovieController::class, 'show']);
Route::post('/movies/create', [MovieController::class, 'store']);
Route::put('/movies/{movie}/edit', [MovieController::class, 'update']);
Route::delete('/movies/{movie}/delete', [MovieController::class, 'destroy']);

Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}/show', [GenreController::class, 'show']);
Route::post('/genres/create', [GenreController::class, 'store']);
Route::put('/genres/{genre}/edit', [GenreController::class, 'update']);
Route::delete('/genres/{genre}/delete', [GenreController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
