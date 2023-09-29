<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
