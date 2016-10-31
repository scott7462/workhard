<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post("/user",'UserController@register');

Route::put("/user",'UserController@update')
->middleware('auth:api');

Route::post("/user/login",'UserController@login');

Route::post("/exercise",'ExerciseController@create');

Route::get('/exercise','ExerciseController@findAll')
->middleware('auth:api');

Route::post("/workout",'WorkoutController@create');

Route::get('/workout','WorkoutController@getGenerals')
->middleware('auth:api');;

Route::post("/workout/save",'WorkoutController@save')
->middleware('auth:api');

Route::get("/workout/my",'WorkoutController@findMyWorkouts')
->middleware('auth:api');