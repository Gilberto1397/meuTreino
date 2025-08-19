<?php

namespace App\Contracts;

use App\Http\Requests\CreateExerciseRequest;
use App\Models\Exercise;

interface ExerciseRepository
{
    /**
     * Create a new exercise with its repetitions.
     * @param CreateExerciseRequest $request
     * @return bool
     * @throws \DomainException
     */
    public function createExercise(CreateExerciseRequest $request): bool;

    /**
     * Return all exercises.
     * @return Exercise[]|array
     */
    public function getAll(): array;
}