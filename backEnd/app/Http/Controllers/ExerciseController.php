<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Repositories\ExerciseRepositoryEloquent;
use App\Services\CreateExerciseService;

class ExerciseController extends Controller
{
    public function createExercise(CreateExerciseRequest $request) //testar multiplo formrequest
    {
        try {
            $response = (new CreateExerciseService())->createExercise(new ExerciseRepositoryEloquent(), $request);
            return response()->json(['mensagem' => $response->getMessage(), 'error' => $response->getError()], 201);
        } catch (\DomainException $exception) {
            return response()->json([
                'mensagem' => $exception->getMessage(),
                'error' => true,
            ], 500);
        }
    }
}
