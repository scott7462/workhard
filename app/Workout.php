<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
   public function exercises(){
   		return $this->belongsToMany("App\Exercise","workouts_exercises")
   			->withPivot('repetitions','position');;
   }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','rest_between_exercise','rest_rounds_exercise','rounds','exercises',
    ];

    protected $hidden = [
        'created_at','updated_at','pivot'
    ];
}
