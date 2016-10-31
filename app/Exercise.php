<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','url','repetitions','positions',
    ];

    protected $hidden = [
        'created_at','updated_at','pivot',
    ];
}
