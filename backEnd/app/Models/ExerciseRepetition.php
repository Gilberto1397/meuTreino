<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $exercises_repetitions_id
 * @property int exercises_repetitions_exercises
 * @property float exercises_repetitions_weight
 * @property int exercises_repetitions_times
 * @property int exercises_repetitions_rest
 */
class ExerciseRepetition extends Model
{
    use HasFactory;

    protected $table = 'exercises_repetitions';
    protected $primaryKey = 'exercises_repetitions_id';
    public $timestamps = false;
}
