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

    /**
     * @param array $exercises
     * @return array
     */
    public static function firstData(array $exercises): array
    {
        $dados = [];

        foreach ($exercises as $exercise) {
            $dados[] = ExerciseResource::firstData($exercise);
        }
        return $dados;
    }

    /**
     * @param array $exerciseData
     * @return array
     */
    public static function fullData(array $exerciseData): array
    {
        return ExerciseResource::fullData($exerciseData);
    }
}
