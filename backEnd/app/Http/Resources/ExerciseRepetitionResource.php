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

    public static function getSeries($repetitionId, $exerciseId, $weight, $repetitions, $rest, $details)
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
