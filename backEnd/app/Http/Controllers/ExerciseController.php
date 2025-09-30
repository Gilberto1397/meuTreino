<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Repositories\ExerciseRepositoryEloquent;
use App\Services\CreateExerciseService;
use App\Services\GetAllExercicesService;
use App\Services\GetExerciseByFiltersService;
use App\Services\UpdateExerciseService;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    /**
     * @param CreateExerciseRequest $request
     * @throws \DomainException
     * @return JsonResponse
     */
    public function createExercise(CreateExerciseRequest $request): JsonResponse //testar multiplo formrequest
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

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $resposta = (new GetAllExercicesService())->getAll(new ExerciseRepositoryEloquent());
        return response()->json(
            ['error' => $resposta->getError(), 'data' => $resposta->getData()],
            $resposta->getStatusCode()
        );
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getExerciseByFilters(int $id): JsonResponse //todo refatorar para mais filtros
    {
        if (!filter_var($id, FILTER_VALIDATE_INT) || empty($id)) {
            return response()->json(
                ['error' => true, 'message' => 'ID inválido'], //todo arrumar variável $response
                500
            );
        }

        $response = (new GetExerciseByFiltersService())->getExerciseByFilters(new ExerciseRepositoryEloquent(), $id);
        return response()->json(
            ['error' => $response->getError(), 'data' => $response->getData()],
            $response->getStatusCode()
        );
    }

    /**
     * @param UpdateExerciseRequest $request
     * @throws \DomainException
     * @return JsonResponse
     */
    public function updateExercise(UpdateExerciseRequest $request): JsonResponse
    {
        try {
            $response = (new UpdateExerciseService())->updateExercise(new ExerciseRepositoryEloquent(), $request);
            return response()->json(
                ['mensagem' => $response->getMessage(), 'error' => $response->getError()],
                $response->getStatusCode()
            );
        } catch (\DomainException $exception) {
            return response()->json([
                'mensagem' => $exception->getMessage(),
                'error' => true,
            ], 500);
        }
    }
}
