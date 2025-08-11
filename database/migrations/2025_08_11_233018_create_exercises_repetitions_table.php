<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesRepetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises_repetitions', function (Blueprint $table) {
            $table->smallIncrements('exercises_repetitions_id');
            $table->unsignedInteger('exercises_repetitions_exercises');
            $table->smallInteger('exercises_repetitions_weight')->nullable();
            $table->smallInteger('exercises_repetitions_times')->nullable();
            $table->smallInteger('exercises_repetitions_rest')->nullable();

            $table
                ->foreign('exercises_repetitions_exercises')
                ->references('exercises_id')
                ->on('exercises')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises_repetitions');
    }
}
