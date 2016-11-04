<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Validator;
use App\Workout;
use Auth;

class WorkoutController extends Controller
{

	public function orderExercisesWorkouts($results){
		foreach($results as $workout) { 
			foreach ($workout->exercises as $exercise) {
				$exercise->position = $exercise->pivot->position; 
				$exercise->repetitions = $exercise->pivot->repetitions; 
			}
		}
		return $results;
	}

    protected function create(Request $request)
    {
	   $workout = $this->createWorkout($request);
       $result = Workout::where('id',$workout->id)->with('exercises')->get();
	   $result = $this->orderExercisesWorkouts($result);
       return response(['workout'=>$result],Response::HTTP_OK);
    }

    public function createWorkout($request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'rest_between_exercise' => 'required',
            'rest_rounds_exercise' => 'required',
            'rounds' => 'required',
            'exercises' => 'required|array',]);
       
       	if($validator->fails()){
            return response(['result' => $validator->errors()->all()],Response::HTTP_BAD_REQUEST);
        }

         $workout = Workout::create([
            'name' => $request->input('name'),
            'rest_between_exercise' => $request->input('rest_between_exercise'),
            'rest_rounds_exercise' => $request->input('rest_rounds_exercise'),
            'rounds' => $request->input('rest_rounds_exercise'),
            ]);
       
       foreach ($request->input('exercises') as $exercise) {
       		$workout->exercises()
       			->attach($exercise['id'], 
       				array("repetitions"=>$exercise['repetitions'], "position"=>$exercise['position']));
       }
       return $workout;
    }

    protected function getGenerals(Request $request)
    {
       $results = $results = Workout::with('exercises')->get();
       $results = $this->orderExercisesWorkouts($results);
        return response(['workouts'=>$results],Response::HTTP_OK);
    }

    protected function save(Request $request)
    {
       $user = Auth::user();
  	   $workout = $this->createWorkout($request);
  	   $user->workouts()
         			->attach($workout['id'], 
         				array("owner"=>true));

       $result = Workout::where('id',$workout->id)->with('exercises')->get();
	   $result = $this->orderExercisesWorkouts($result);
       return response(['workout'=>$result],Response::HTTP_OK);
    }

    protected function findMyWorkouts(Request $request)
    {
       $user = Auth::user();
       $results = $user->workouts;
	     // $results = $this->orderWorkouts($results);
	     $results = $this->orderExercisesWorkouts($results);
        return response(['workouts'=>$results],Response::HTTP_OK);
    }

  //   protected function orderWorkouts($results){
		// foreach($results as $workout) { 
		// 	$workout->completed = $workout->pivot->completed; 
		// 	$workout->date_complete = $workout->pivot->date_complete; 
		// }
		// return $results;
  //   }

    protected function completeWorkout($results){

       $user = Auth::user();
	   $validator = Validator::make($request->all(), [
            'workout_id' => 'required',]);
	   	if($validator->fails()){
            return response(['result' => $validator->errors()->all()],Response::HTTP_BAD_REQUEST);
        }
       $user = Auth::user();
	   $user->workouts->where('workout_id',$request->input('workout_id'))->update(['completed' => true]);
	   return response(['workout'=>$result],Response::HTTP_OK);
    }

	

}
