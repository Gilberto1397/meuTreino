<?php

namespace App\Services;

use App\Contracts\ExerciseRepository;
use App\Helpers\OrganizeResponse;
use App\Http\Requests\UpdateExerciseRequest;

class UpdateExerciseService
{
    /**
     * @param ExerciseRepository $repository
     * @param UpdateExerciseRequest $request
     * @return OrganizeResponse
     */
    public function updateExercise(ExerciseRepository $repository, UpdateExerciseRequest $request): OrganizeResponse
    {
        $response = $repository->updateExercise($request);
        return new OrganizeResponse(200, 'Exercício atualizado com sucesso!');
    }
}
