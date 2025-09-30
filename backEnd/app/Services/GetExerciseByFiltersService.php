<?php

namespace App\Services;

use App\Contracts\ExerciseRepository;
use App\Helpers\OrganizeResponse;
use App\Http\Resources\ExerciseResourceCollection;

class GetExerciseByFiltersService
{
    /**
     * @param ExerciseRepository $repository
     * @param int $id
     * @return OrganizeResponse
     */
    public function getExerciseByFilters(ExerciseRepository $repository, int $id): OrganizeResponse
    {
        return new OrganizeResponse(
            200,
            '',
            ExerciseResourceCollection::fullData($repository->getExerciseByFilters($id))
        );
    }
}
