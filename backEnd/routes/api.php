<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Models\Exercise;
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

Route::middleware(['auth:api'])->prefix('meus-exercicios')->group(function () {
    Route::post('', [ExerciseController::class, 'createExercise']);
    Route::get('', function() {
        return Exercise::all();
    });
});

Route::prefix('autenticacao')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
//    Route::post('refresh', 'refresh');
//    Route::get('me', 'me');
});