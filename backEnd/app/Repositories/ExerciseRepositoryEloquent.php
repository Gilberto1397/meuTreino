<?php

namespace App\Repositories;

use App\Contracts\ExerciseRepository;
use App\Http\Requests\CreateExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Exercise;
use App\Models\ExerciseRepetition;
use Illuminate\Support\Facades\DB;

class ExerciseRepositoryEloquent implements ExerciseRepository
{
    /**
     * @param CreateExerciseRequest $request
     * @throws \DomainException
     * @return bool
     */
    public function createExercise(CreateExerciseRequest $request): bool
    {
        DB::beginTransaction();

        $exercise = Exercise::create([
            'exercises_name' => $request->name,
            'exercises_details' => $request->exerciseDetails,
            'exercises_users' => auth()->user()->id,
        ]);

        if (!$exercise instanceof Exercise) {
            DB::rollBack();
            throw new \DomainException('Falha ao salvar o exercício!');
        }
        $this->saveRepetitions($request->serie, $exercise);

        DB::commit();
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
                   coalesce((select count(exercises_repetitions_exercises) from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id), 0) as series,
                    coalesce((select exercises_repetitions_repetitions from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1), 0) as first_repetitions,
                    coalesce((select exercises_repetitions_weight from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1), 0) as first_weight,
                    coalesce((select exercises_repetitions_rest from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id order by exercises_repetitions_id limit 1), 0) as first_rest
                from exercises
            order by exercises_name
        ')->all();
    }

    public function getExerciseByFilters(int $id): array
    {
        return Exercise::fromQuery('
            select exercises.*,
                   coalesce((select count(exercises_repetitions_exercises) from exercises_repetitions
                    where exercises_repetitions_exercises = exercises_id), 0) as seriesQuantity,
                   exercises_repetitions.*
            from exercises
            left join exercises_repetitions on exercises_repetitions_exercises = exercises_id
            where exercises_id = :id
            order by exercises_name, exercises_repetitions_id
        ', [':id' => $id])->all();
    }

    public function updateExercise(UpdateExerciseRequest $request): bool
    {
        DB::beginTransaction();

        if (empty($request->exerciseId) || ! $exercise = Exercise::find($request->exerciseId)) {
            db::rollBack();
            throw new \DomainException('Exercício não encontrado!');
        }
        $updated = $exercise->update([
            'exercises_name' => $request->name,
            'exercises_details' => $request->exerciseDetails,
            'exercises_users' => auth()->user()->id,
        ]);

        if (! $updated) {
            db::rollBack();
            throw new \DomainException('Falha ao atualizar o exercício!');
        }
        $this->saveRepetitions($request->serie, $exercise, true);
        DB::commit();
        return true;
    }


    private function saveRepetitions(array $series, Exercise $exercise, bool $deleteRepetitions = false): void
    {
        if (!empty($series)) {
            $repetitions = [];

            if ($deleteRepetitions) {
                $deletedRepetitions = DB::delete(
                    'delete from exercises_repetitions where exercises_repetitions_exercises = :id',
                    [':id' => $exercise->exercises_id]
                );

                if (!is_int($deletedRepetitions)) {
                    db::rollBack();
                    throw new \DomainException('Falha ao atualizar as séries do exercício!');
                }
            }

            foreach ($series as $serie) {
                $repetitions[] = [
                    'exercises_repetitions_exercises' => $exercise->exercises_id,
                    'exercises_repetitions_weight' => !empty($serie['weight']) ? $serie['weight'] : null,
                    'exercises_repetitions_repetitions' => !empty($serie['repetitions']) ? $serie['repetitions'] : null,
                    'exercises_repetitions_rest' => !empty($serie['rest']) ? $serie['rest'] : null,
                    'exercises_repetitions_details' => !empty($serie['details']) ? $serie['details'] : null,
                ];
            }

            if (!ExerciseRepetition::insert($repetitions)) {
                db::rollBack();
                throw new \DomainException('Falha ao atualizar as séries do exercício!');
            }
        }
    }
}
