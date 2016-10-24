<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkoutRelationshipsExercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('workouts_exercises', function(Blueprint $table)
      {
        $table->increments('id');
        $table->integer('workout_id')->unsigned();
        $table->foreign('workout_id')
        ->references('id')->on('workouts');
        $table->integer('exercise_id')->unsigned();
        $table->foreign('exercise_id')
        ->references('id')->on('exercises');
        $table->integer('repetitions');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('workouts_exercises');
    }
}
