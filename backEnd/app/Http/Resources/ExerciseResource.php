<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    public static $wrap = 'exercise';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->exercises_id, //todo utilizar uuid
            'name' => $this->exercises_name,

            //todo validar se da erro caso não exista repetições, peso ou descanso
        ];
    }

    public static function firstData($exercise)
    {
        return (object)[
            'id' => $exercise->exercises_id, //todo utilizar uuid
            'name' => $exercise->exercises_name,
            'series' => $exercise->series,
            'firstRepetitions' => $exercise->first_repetitions,
            'firstWeight' => $exercise->first_weight,
            'firstRest' => $exercise->first_rest,
        ];
    }

    public static function fullData($exerciseData)
    {
        $exercises = [];
        $exerciseId = null;

        foreach ($exerciseData as $exercise) {
            if ($exercise->exercises_id !== $exerciseId) {
                $seriesKey = $exercise->exercises_id;
                $exercises[$seriesKey] = (object)[
                    'id' => $exercise->exercises_id, //todo utilizar uuid e na chave do array
                    'name' => $exercise->exercises_name,
                    'seriesCount' => $exercise->seriesQuantity,
                ];
                $exerciseId = $exercise->exercises_id;
            }
            $exercises[$seriesKey]->serie[] = ExerciseRepetitionResource::getSeries(
                $exercise->exercises_repetitions_id,
                $exercise->exercises_id,
                $exercise->exercises_repetitions_weight,
                $exercise->exercises_repetitions_repetitions,
                $exercise->exercises_repetitions_rest
            );
        }
        return array_values($exercises);
    }
}
