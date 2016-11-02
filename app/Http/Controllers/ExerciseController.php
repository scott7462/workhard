<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Validator;

use App\Exercise;

class ExerciseController extends Controller
{

    protected function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:1500',
            'url' => 'required|url|max:250',
            ]);

        if($validator->fails()){
            return response(['result' => $validator->errors()->all()],Response::HTTP_BAD_REQUEST);
        }

        $exercise = Exercise::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'url' => $request->input('url'),
            ]);
        
        return response(['exercise'=>$exercise],Response::HTTP_OK);
    }

    protected function findAll(Request $request)
    {
        return response(['exercises'=>Exercise::all()],Response::HTTP_OK);
    }



}
