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
        //todo vai quebrar se não informar valor para os dados de repetição
        return Exercise::fromQuery('
            select exercises_id,
                   exercises_name,
                   (select count(exercises_repetitions_exercises) from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id) as series,
                    (select exercises_repetitions_repetitions from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as first_repetitions,
                    (select exercises_repetitions_weight from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as first_weight,
                    (select exercises_repetitions_rest from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1) as first_rest
                from exercises
            order by exercises_name
        ')->all();
    }

    public function getExerciseByFilters(int $id): array
    {
        return Exercise::fromQuery('
            select exercises.*,
                   exercises_repetitions.*
            from exercises
            inner join exercises_repetitions on exercises_repetitions_exercises = exercises_id
            where exercises_id = :id
            order by exercises_name
        ', [':id' => $id])->all();
    }
}
