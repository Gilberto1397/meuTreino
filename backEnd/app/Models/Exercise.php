<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $exercises_id
 * @property string $exercises_name
 * @property int $exercises_users
 */
class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';
    protected $primaryKey = 'exercises_id';
    public $timestamps = false;

    protected $fillable = [
        'exercises_name',
        'exercises_users',
    ];
}
