<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()){ 
            if(Auth::user()->user_type == "C"){
                return $next($request);
            }
        }else{
            return Redirect('/');
        }
        
        return Redirect('login');
    }
}
