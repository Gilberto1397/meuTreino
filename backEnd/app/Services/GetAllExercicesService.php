<?php

namespace App\Services;

use App\Contracts\ExerciseRepository;
use App\Helpers\OrganizeResponse;
use App\Http\Resources\ExerciseResourceCollection;

class GetAllExercicesService
{
    /**
     * Retrieve all exercises from the repository.
     * @param ExerciseRepository $repository
     * @return OrganizeResponse
     */
    public function getAll(ExerciseRepository $repository): OrganizeResponse
    {
        return new OrganizeResponse(200, '', ExerciseResourceCollection::firstData($repository->getAll()));
    }
}
