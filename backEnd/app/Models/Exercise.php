<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $exercises_id
 * @property string $exercises_name
 * @property string $exercises_details
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
        'exercises_details',
        'exercises_users',
    ];
}
