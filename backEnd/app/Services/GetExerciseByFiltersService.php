<?php

namespace App\Services;

use App\Contracts\ExerciseRepository;
use App\Helpers\OrganizeResponse;
use App\Http\Resources\ExerciseResourceCollection;

class GetExerciseByFiltersService
{
    public function getExerciseByFilters(ExerciseRepository $repository, int $id)
    {
        return new OrganizeResponse(
            200,
            '',
            ExerciseResourceCollection::fullData($repository->getExerciseByFilters($id))
        );
    }
}
