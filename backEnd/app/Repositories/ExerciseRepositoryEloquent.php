<?php

namespace App\Repositories;

use App\Contracts\ExerciseRepository;
use App\Http\Requests\CreateExerciseRequest;
use App\Models\Exercise;
use App\Models\ExerciseRepetition;

class ExerciseRepositoryEloquent implements ExerciseRepository
{
    /**
     * @param CreateExerciseRequest $request
     * @throws \DomainException
     * @return bool
     */
    public function createExercise(CreateExerciseRequest $request): bool
    {
        $exercise = Exercise::create([
            'exercises_name' => $request->exercises_name,
            'exercises_users' => $request->exercises_users,
        ]);

        if (!$exercise instanceof Exercise) {
            throw new \DomainException('Falha ao salvar o exercício!');
        }
        if (!empty($request->serie)) {
            $repetitions = [];

            foreach ($request->serie as $serie) {
                $repetitions[] = [
                    'exercises_repetitions_exercises' => $exercise->exercises_id,
                    'exercises_repetitions_weight' => $serie['weight'],
                    'exercises_repetitions_repetitions' => $serie['repetitions'],
                    'exercises_repetitions_rest' => $serie['rest'],
                ];
            }

            if (!ExerciseRepetition::insert($repetitions)) {
                throw new \DomainException('Falha ao salvar as séries do exercício!');
            }
        }
        return true;
    }
}