<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Repositories\ExerciseRepositoryEloquent;
use App\Services\CreateExerciseService;
use App\Services\GetAllExercicesService;
use App\Services\GetExerciseByFiltersService;

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

    public function getAll()
    {
        $resposta = (new GetAllExercicesService())->getAll(new ExerciseRepositoryEloquent());
        return response()->json(
            ['error' => $resposta->getError(), 'data' => $resposta->getData()],
            $resposta->getStatusCode()
        );
    }

    public function getExerciseByFilters()
    {
        $response = (new GetExerciseByFiltersService())->getExerciseByFilters(new ExerciseRepositoryEloquent(), 3);
        return response()->json(
            ['error' => $response->getError(), 'data' => $response->getData()],
            $response->getStatusCode()
        );
    }
}
