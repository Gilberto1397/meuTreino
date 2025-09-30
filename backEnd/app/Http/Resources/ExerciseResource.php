<?php

namespace App\Http\Resources;

use App\Models\Exercise;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    public static $wrap = 'exercise';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @phpstan-ignore-next-line
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [];
    }

    /**
     * @param Exercise $exercise
     * @return Object
     */
    public static function firstData(Exercise $exercise): Object
    {
        return (object)[
            'id' => $exercise->exercises_id, //todo utilizar uuid
            'name' => $exercise->exercises_name,
            'series' => $exercise->series, //@phpstan-ignore-line
            'firstRepetitions' => $exercise->first_repetitions, //@phpstan-ignore-line
            'firstWeight' => $exercise->first_weight, //@phpstan-ignore-line
            'firstRest' => $exercise->first_rest, //@phpstan-ignore-line
        ];
    }

    /**
     * @param array $exerciseData
     * @return array
     */
    public static function fullData(array $exerciseData): array
    {
        $exercises = [];
        $exerciseId = null;
        $seriesKey = $exerciseData[0]->exercises_id;

        foreach ($exerciseData as $exercise) {
            if ($exercise->exercises_id !== $exerciseId) {
                $exercises[$seriesKey] = (object)[
                    'id' => $exercise->exercises_id, //todo utilizar uuid e na chave do array
                    'name' => $exercise->exercises_name,
                    'exerciseDetails' => $exercise->exercises_details,
                    'seriesCount' => $exercise->seriesQuantity,
                ];
                $exerciseId = $exercise->exercises_id;
            }
            $exercises[$seriesKey]->serie[] = ExerciseRepetitionResource::getSeries(
                $exercise->exercises_repetitions_id,
                $exercise->exercises_id,
                $exercise->exercises_repetitions_weight,
                $exercise->exercises_repetitions_repetitions,
                $exercise->exercises_repetitions_rest,
                $exercise->exercises_repetitions_details
            );
        }
        return array_values($exercises);
    }
}
