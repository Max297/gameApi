<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gamesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getGame',[gamesController::class,'getGame']);
Route::post('/addGame',[gamesController::class,'addGame']);
Route::post('/delGame',[gamesController::class,'delGame']);
Route::post('/changeGame',[gamesController::class,'changeGame']);
Route::get('/getGamesByGenre',[gamesController::class,'getGamesByGenre']);
