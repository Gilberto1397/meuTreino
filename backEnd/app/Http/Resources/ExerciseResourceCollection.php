<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ExerciseResourceCollection extends ResourceCollection
{
    public $collects = ExerciseResource::class;

    public static $wrap = 'exercises';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public static function firstData($exercises)
    {
        $dados = [];

        foreach ($exercises as $exercise) {
            $dados[] = ExerciseResource::firstData($exercise);
        }
        return $dados;
    }

    public static function fullData($exerciseData)
    {
        return ExerciseResource::fullData($exerciseData);
    }
}
