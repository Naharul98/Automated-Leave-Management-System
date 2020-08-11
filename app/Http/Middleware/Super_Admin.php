<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;

class Super_Admin
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
        if(Auth::user()->role === "super_admin")
        {
            return $next($request);
        }
        else
        {
             return redirect('/home')->with('error', 'Error 403 - Unauthorized action');
        }
    }
}
