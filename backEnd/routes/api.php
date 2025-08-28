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

Route::middleware(['auth:api'])->controller(ExerciseController::class)->prefix('meus-exercicios')->group(function () {
    Route::get('/{id}', 'getExerciseByFilters');
    Route::get('', 'getAll');
    Route::post('', 'createExercise');
    Route::put('', 'updateExercise');
});

Route::prefix('autenticacao')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::delete('logout', 'logout');
//    Route::post('refresh', 'refresh');
//    Route::get('me', 'me');
});
