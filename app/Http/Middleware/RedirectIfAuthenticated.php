<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() || $request->wantsJson()) {
            return redirect('/home');
        }else{
            return  response([
            'status' => Response::HTTP_UNAUTHORIZED,    
            'code' => 401,
            'error' => 'Unauthorized User',
            ],Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
