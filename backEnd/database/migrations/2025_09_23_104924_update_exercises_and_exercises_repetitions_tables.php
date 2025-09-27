<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExercisesAndExercisesRepetitionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->string('exercises_details')->nullable();
        });

        Schema::table('exercises_repetitions', function (Blueprint $table) {
            $table->string('exercises_repetitions_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn('exercises_details');
        });

        Schema::table('exercises_repetitions', function (Blueprint $table) {
            $table->dropColumn('exercises_repetitions_details');
        });
    }
}
