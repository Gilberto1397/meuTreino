<?php

namespace App\Http\Requests;

/**
 * @property int $exerciseId
 */
class UpdateExerciseRequest extends CreateExerciseRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'exerciseId' => ['required', 'integer', 'exists:exercises,exercises_id'],
        ]);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'exerciseId.required' => 'É necessário informar o ID do exercício!',
            'exerciseId.integer' => 'O ID do exercício está inválido!',
            'exerciseId.exists' => 'O exercício informado não existe!',
        ]);
    }
}
