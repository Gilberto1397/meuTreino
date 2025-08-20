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
            'exercises_name' => $request->name,
            'exercises_users' => 1, //todo tirar valor fixo
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

    /**
     * Return all exercises.
     * @return array|Exercise[]
     */
    public function getAll(): array
    {
        return Exercise::fromQuery('
            select exercises_id,
                   exercises_name,
                   (select count(exercises_repetitions_exercises) from exercises_repetitions 
                    where exercises_repetitions_exercises = exercises_id) as series,
                    (select exercises_repetitions_repetitions from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as fisrt_repetitions,
                    (select exercises_repetitions_weight from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as first_weight,
                    (select exercises_repetitions_rest from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as first_rest
                from exercises
            order by exercises_name
        ')->all();
    }
}