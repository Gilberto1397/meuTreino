<?php

namespace App\Services;

use App\Contracts\ExerciseRepository;
use App\Helpers\OrganizeResponse;
use App\Http\Requests\CreateExerciseRequest;

class CreateExerciseService
{
    /**
     * @param ExerciseRepository $repository
     * @param CreateExerciseRequest $request
     * @return OrganizeResponse
     *@throws \DomainException
     */
    public function createExercise(ExerciseRepository $repository, CreateExerciseRequest $request): OrganizeResponse
    {
        $repository->createExercise($request);
        return new OrganizeResponse(201, 'Exercício salvo com sucesso!');
    }
}