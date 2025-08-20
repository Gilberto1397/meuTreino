<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    public static $wrap = 'exercise';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->exercises_id, //todo utilizar uuid
            'name' => $this->exercises_name,
            'series' => $this->series,
            'firstRepetitions' => $this->fisrt_repetitions,
            'firstWeight' => $this->first_weight,
            'firstRest' => $this->first_rest,
        ];
    }
}
