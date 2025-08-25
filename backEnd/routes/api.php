<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

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

Route::middleware([])->controller(ExerciseController::class)->prefix('meus-exercicios')->group(function () { //todo MIDDLEWARE
    Route::post('', 'createExercise');
    Route::get('', 'getAll');
    Route::get('/{id}', 'getExerciseByFilters');
});

Route::prefix('autenticacao')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
//    Route::post('refresh', 'refresh');
//    Route::get('me', 'me');
});
