<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseRepetitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    /**
     * @param int $repetitionId
     * @param int $exerciseId
     * @param int $weight
     * @param int $repetitions
     * @param int $rest
     * @param string $details
     * @return Object
     */
    public static function getSeries(int $repetitionId, int $exerciseId, int $weight, int $repetitions, int $rest, string $details): Object
    {
        return (object)[
            'id' => $repetitionId, //todo utilizar uuid
            'exerciseId' => $exerciseId,
            'weight' => $weight,
            'repetitions' => $repetitions,
            'rest' => $rest,
            'details' => $details
        ];
    }
}
