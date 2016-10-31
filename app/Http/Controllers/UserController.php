<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use Validator;

use App\User;

use Auth;

class UserController extends Controller
{

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6',
            'birthdate' => 'required',
            ]);

        if($validator->fails()){
            return response(['result' => $validator->errors()->all()],Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'birthdate' => $request->input('birthdate'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            ]);
        
        $token = $user->createToken('accessToken')->accessToken;
        return response(['user'=>$user,'token'=>['access_token'=>$token]],Response::HTTP_OK);
    }


    protected function login(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:50',
            'password' => 'required|min:6',
            ]);

        if($validator->fails()){
            return response(['result' => $validator->errors()->all()],Response::HTTP_BAD_REQUEST);
        }
        $data = $request->all();

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'] ])) {
            $user = Auth::user();
            $token = $user->createToken('token')->accessToken;
            return response(['user'=>$user,'token'=>['access_token'=>$token]],Response::HTTP_OK);
        }

        return response([
            'status' => Response::HTTP_UNAUTHORIZED,
            'response_time' => microtime(true) - LARAVEL_START,
            'code' => 201,
            'error' => 'Wrong email or password',
            ],Response::HTTP_UNAUTHORIZED);
    }

}
