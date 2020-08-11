<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;

class AdminMiddleware
{


    public function __construct()
    {
  
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role == "manager")
        {
            return $next($request);
        }
        else
        {
            return redirect('/home')->with('error', 'Error 403 - Unauthorized action');
        }
        
    }
}
