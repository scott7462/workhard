<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRelationshipsWorkouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_workouts', function(Blueprint $table)
      {
        $table->increments('id');
        $table->integer('workout_id')->unsigned();
        $table->foreign('workout_id')
        ->references('id')->on('workouts');
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')
        ->references('id')->on('users');
        $table->boolean('owner')->default(false);
        $table->boolean('completed')->default(false);
        $table->timestampTz('date_complete');
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
        Schema::drop('users_workouts');
    }
}
