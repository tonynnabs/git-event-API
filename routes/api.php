<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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
Route::get('/events', [EventController::class, 'allEvents']);
Route::post('/events', [EventController::class, 'store']);
Route::delete('/erase', [EventController::class, 'erase']);
Route::get('/events/actors/{actorId}', [EventController::class, 'filter']);
Route::put('/actors', [EventController::class, 'updateActor']);
Route::get('/actors', [EventController::class, 'showActors']);
Route::get('/actors/streak', [EventController::class, 'streak']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
