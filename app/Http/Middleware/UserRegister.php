<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class UserRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check() == false)
        {
            return $next($request);
        }
        if(Auth::user()->role === "student" || Auth::user()->role === "admin")
        {

            return redirect('/home')->with('error', 'Error 403 - Unauthorized action');
        }
        else
        {
            return $next($request);
        }
    }
}
