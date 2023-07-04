<?php

namespace App\Http\Middleware;
Use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Closure;

class IsAdminMiddleware
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
        if (Auth::user()) {
            if(Auth::user()->user_type == "A"){
                return $next($request);
            }
        }else{
            return Redirect::to('admin');
        }  
    }
}
