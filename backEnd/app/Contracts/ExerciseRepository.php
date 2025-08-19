<?php

namespace App\Contracts;

use App\Http\Requests\CreateExerciseRequest;

interface ExerciseRepository
{
    /**
     * Create a new exercise with its repetitions.
     * @throws \DomainException
     * @return bool
     */
    public function createExercise(CreateExerciseRequest $request): bool;
}