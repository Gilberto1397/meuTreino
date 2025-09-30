<?php

namespace App\Http\Requests;

use App\Models\Exercise;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string|null $exerciseDetails
 * @property array $serie
 */
class CreateExerciseRequest extends BaseExerciseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('exercises', 'exercises_name')->ignore(Exercise::find($this->id))],
            'exerciseDetails' => ['string', 'max:255'],
            'serie' => ['array'],
            'serie.*.weight' => ['required', 'numeric', 'min:1'],
            'serie.*.repetitions' => ['required', 'integer', 'min:1'],
            'serie.*.rest' => ['required', 'integer', 'min:1'],
            'serie.*.details' => ['string', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'É necessário informar o nome do exercício!',
            'name.string' => 'O nome do exercício está inválido!',
            'name.max' => 'O nome do exercício deve ter no máximo 255 caracteres!',
            'name.unique' => 'Já existe um exercício cadastrado com este nome!',

            'exerciseDetails.string' => 'Detalhe de exercício inválido!',
            'exerciseDetails.max' => 'O detalhe do exercício deve ter no máximo 255 caracteres!',

            'serie.array' => 'As informações sobre as séries do exercício estão inválidas!',
            'serie.*.weight.required' => 'É necessário informar o peso para esta série!',
            'serie.*.weight.numeric' => 'O peso informado para esta série está inválido!',
            'serie.*.weight.min' => 'O peso informado para esta série deve ser no mínimo 1Kg!',

            'serie.*.repetitions.required' => 'É necessário informar a quantidade de repetições para esta série!',
            'serie.*.repetitions.integer' => 'A quantidade de repetições informada para esta série está inválida!',
            'serie.*.repetitions.min' => 'A quantidade de repetições informada para esta série deve ser no mínimo 1!',

            'serie.*.rest.required' => 'É necessário informar o tempo de descanso após esta série!',
            'serie.*.rest.integer' => 'O tempo de descanso informado após esta série está inválido!',
            'serie.*.rest.min' => 'O tempo de descanso informado após esta série deve ser no mínimo 1 segundo!',

            'serie.*.details.string' => 'Detalhe de série inválido!',
            'serie.*.details.max' => 'O detalhe da série deve ter no máximo 255 caracteres!'
        ];
    }

    protected function prepareForValidation(): void
    {
        $series = $this->serie;

        if (!empty($series)) {
            foreach ($series as $key => $serie) {
                if (!empty($serie['details'])) {
                    $series[$key]['details'] = strip_tags($serie['details']);
                }
            }
        }

        $this->merge([
            'name' => strip_tags($this->name),
            'exerciseDetails' => strip_tags($this->exerciseDetails),
            'serie' => $series
        ]);
    }
}
